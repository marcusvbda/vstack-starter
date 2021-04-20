<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Models\{Campaign};
use Illuminate\Http\Request;
use ResourcesHelpers;
use marcusvbda\vstack\Services\Messages;
use  marcusvbda\vstack\Controllers\ResourceController;

class CampaignsController extends Controller
{
	public function leads($code)
	{
		$campaign = Campaign::findByCodeOrFail($code); //apenas para validação
		$campaign_resource = ResourcesHelpers::find("leads");
		$lead_resource = ResourcesHelpers::find("leads");
		if (!$campaign_resource->canViewList() || !$lead_resource->canViewList()) abort(403);
		$resources = [
			"campaign" => [
				"icon" => $campaign_resource->icon()
			],
			"leads" => [
				"icon" => $lead_resource->icon()
			]
		];
		$resource_filters = $lead_resource->filters();
		return view("admin.campaigns.index", compact("campaign", "resources", "resource_filters"));
	}

	public function list($code, Request $request)
	{
		$resource = ResourcesHelpers::find("leads");
		$campaign = Campaign::findByCodeOrFail($code);
		if (!$resource->canViewList()) abort(403);
		$controller = new ResourceController();
		$fake_request = $campaign->query_filters_request_type;
		$data = $controller->getData($resource, $fake_request);
		$per_page = $controller->getPerPage($resource);
		$data = $data->paginate($per_page);
		$data->map(function ($query) {
			$query->setAppends([]);
		});
		return response()->json($data);
	}

	public function store(Request $request)
	{
		$data = $request->only(["id", "name", "duedate"]);
		$filter = $request->except(["name", "duedate", "resource_id", "polo_id", "id"]);

		$resource = ResourcesHelpers::find("campanhas");
		if (@$data["id"]) if (!$resource->canUpdate()) abort(403);
		if (!@$data["id"]) if (!$resource->canCreate()) abort(403);
		$validation_custom_message =  $resource->getValidationRuleMessage();
		$this->validate($request, $resource->getValidationRule(), @$validation_custom_message ? $validation_custom_message : []);
		$target = @$data["id"] ? $resource->model->findOrFail($data["id"]) : new $resource->model();
		$data = $request->except(["resource_id", "id", "redirect_back"]);
		$target->name = $data["name"];
		$target->duedate = $data["duedate"];
		$target->polo_id = @$data["polo_id"];
		$target->query_filters = $filter;
		$target->save();
		Messages::send("success", "Registro salvo com sucesso !!");
		return ["success" => true, "route" => route('resource.index', ["resource" => $resource->id])];
	}
}
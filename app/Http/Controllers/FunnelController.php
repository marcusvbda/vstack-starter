<?php

namespace App\Http\Controllers;

// use App\Http\Constants\Leads\Statuses;
use Illuminate\Http\Request;
use ResourcesHelpers;
use marcusvbda\vstack\Controllers\ResourceController;
use App\Http\Models\LeadStatus;

class FunnelController extends Controller
{
	public function index(Request $request)
	{
		$resource = static::getProcessedResource();
		$status = LeadStatus::get();
		return view("admin.leads.funnel.index", compact('resource', 'status'));
	}

	public function filter(Request $request)
	{
		$resource = static::getProcessedResource();
		$data = (new ResourceController)->getData($resource, $request);
		$sub_status = LeadStatus::findOrFail($request["status"]);
		$total = $data->count();
		$leads = $data->whereIn("lead_substatus_id", $sub_status->sub_status()->pluck("id"))
			->select("*")
			->paginate($request["per_page"] ? $request["per_page"] : $resource->resultsPerPage()[0]);
		return ["total" => $total, "leads" => $leads];
	}

	public static function getProcessedResource()
	{
		$resource = ResourcesHelpers::find("leads");
		$_filters = [];
		$filters = $resource->filters();
		foreach ($filters as $row) if (get_class($row) != \App\Http\Filters\Leads\LeadsByStatus::class) $_filters[] = $row;
		$filters = $_filters;
		$resource->_filters = $_filters;
		return $resource;
	}

	public function convert($id)
	{
		$resource = ResourcesHelpers::find("leads");
		if (!hasPermissionTo("edit-leads")) abort(403);
		$lead = $resource->model->findOrFail($id);
		$lead->load(["substatus", "substatus.status"]);
		return view("admin.leads.funnel.convert", compact('resource', 'lead'));
	}
}
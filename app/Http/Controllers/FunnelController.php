<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ResourcesHelpers;
use marcusvbda\vstack\Controllers\ResourceController;
use App\Http\Models\{
	LeadStatus,
	ContactType,
	Lead,
	LeadAnswer,
	Objection,
	LeadSubstatus
};
use Carbon\Carbon;
use Auth;

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
		if (!$resource->canUpdate()) abort(403);
		$lead = $resource->model->findOrFail($id);
		$lead->load(["substatus", "substatus.status"]);
		$types = ContactType::get();
		$answers = LeadAnswer::get();
		$objections = Objection::get();
		return view("admin.leads.funnel.convert", compact('resource', 'lead', 'types', 'answers', 'objections'));
	}

	public function finishConvert($id, Request $request)
	{
		$resource = ResourcesHelpers::find("leads");
		if (!$resource->canUpdate()) abort(403);
		$lead = Lead::findOrFail($id);
		$conversions = $lead->conversions;
		$now =  Carbon::now();
		$user = Auth::user();
		$answer = LeadAnswer::findOrFail($request["answer_id"]);
		if ($answer->need_schedule) {
			$status = LeadSubstatus::value("schedule");
			$lead->lead_substatus_id = $status->id;
			$lead->schedule = Carbon::create($request["schedule"]);
		}
		array_unshift($conversions, [
			"obs" => @$request["obs"],
			"date" =>  $now->format("d/m/Y"),
			"desc" => "Converteu no funil de produção",
			"user" => $user->name,
			"timestamp" => $now->format("H:i:s")
		]);
		$lead->conversions = $conversions;
		$lead->save();
		return ["success" => true, "route" => "/admin/funil-de-conversao" . @$request["back_query"]];
	}
}
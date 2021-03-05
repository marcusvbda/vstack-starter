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
	LeadSubstatus,
	CustomAutomation
};
use Carbon\Carbon;
use Auth;
use marcusvbda\vstack\Services\Messages;

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
		// dd($lead->automation_sent_emails);
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
		$now =  Carbon::now();
		$user = Auth::user();
		$answer = LeadAnswer::findOrFail($request["answer_id"]);
		$type = ContactType::findOrfail($request["type_id"]);
		$objection = Objection::find($request["objection_id"]);
		$new_status = $this->getNewStatus($answer);
		$this->sendAutomationEmail($lead, "schedule");

		$lead = $this->logConversions($lead, $now, $user, $new_status);
		$lead = $this->logTries($lead, $now, $user, $type, @$objection->description, @$request["other_objection"], @$request['obs']);

		$lead->lead_substatus_id = $new_status->id;

		if ($answer->need_objection) {
			$objection = $schedule;
			$lead->objection = $objection->description;
			$lead->other_objection = @$request["other_objection"];
		}

		$lead->save();
		Messages::send("success", "Contato Salvo");
		$this->sendAutomationEmail($lead, "conversion");
		return ["success" => true, "route" => "/admin/funil-de-conversao" . @$request["back_query"]];
	}

	private function sendAutomationEmail($lead, $trigger)
	{
		if ($lead->email) {
			foreach (CustomAutomation::where("data->trigger", $trigger)->where("data->lead_status_id", $lead->status->id)->get() as $automation) {
				$automation->execute($lead);
			}
		}
	}

	private function logTries($lead, $now, $user, $type, $objection, $other_objection, $obs)
	{
		$tries = $lead->tries;
		array_unshift($tries, [
			"type" => $type->description,
			"date" => $now->format("d/m/Y"),
			"timestamp" => $now->format("H:i:s"),
			"objection" => @$objection,
			"other_objection" => @$other_objection,
			"obs" => @$obs,
			"user" => $user->name,
			"comment" => null
		]);
		$lead->tries = $tries;
		return $lead;
	}

	private function logConversions($lead, $now, $user, $new_status)
	{
		$conversions = $lead->conversions;
		array_unshift($conversions, [
			"obs" => @$request["obs"],
			"date" =>  $now->format("d/m/Y"),
			"desc" => "Converteu no funil de produção de <b>" . $lead->substatus->name . "</b> para <b>" . $new_status->name . "</b>",
			"user" => $user->name,
			"timestamp" => $now->format("H:i:s")
		]);
		$lead->conversions = $conversions;
		return $lead;
	}

	private function getNewStatus($answer)
	{
		if ($answer->need_objection && $answer->is_neutral) return  LeadSubstatus::value("waiting_with_objection");
		if ($answer->need_schedule && $answer->is_neutral) return  LeadSubstatus::value("schedule");

		if ($answer->need_objection && $answer->is_positive) return  LeadSubstatus::value("has_interest_with_objection");
		if ($answer->need_schedule && $answer->is_positive) return  LeadSubstatus::value("has_interest");

		if ($answer->need_objection && $answer->is_negative) return  LeadSubstatus::value("canceled");
		if ($answer->need_schedule && $answer->is_negative) return  LeadSubstatus::value("possible_non_qualified");

		if ($answer->need_test) return  LeadSubstatus::value("test");

		return  LeadSubstatus::value("waiting");
	}
}
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Models\{CustomAutomation, Lead, AutomationSentEmail};
use Arr;
use marcusvbda\vstack\Services\SendMail;

class runCustomAutomation extends Command
{
	protected $signature = 'command:run-custom-automations';
	protected $description = 'Run Custom Automation';

	public function __construct()
	{
		parent::__construct();
	}

	public function handle()
	{
		foreach (CustomAutomation::get() as $automation) {
			$this->executeAutomation($automation);
		}
	}

	private function executeAutomation($automation)
	{
		$trigger = $automation->trigger;
		$status = $automation->status;
		$leads = $this->getLeads($automation, $status, $trigger);
		foreach ($leads as $lead) {
			$last_automation_execution = $lead->last_automation_execution;
			if (!$last_automation_execution) {
				$this->runAutomation($automation, $lead);
				continue;
			}
			dd("Outro last_automation_execution", $lead->data);
		}
	}

	private function runAutomation($automation, $lead)
	{
		$email_template = $automation->email_template;
		$body = Arr::get($email_template->body, "body");
		$subject = $email_template->subject;
		SendMail::to($lead->email, $subject, $body);
		$this->logExecution($lead, $automation, $email_template);
	}

	private function logExecution($lead, $automation, $email_template)
	{
		$email_content = [
			"subject" => $email_template->subject,
			"body" => $email_template->body,
		];
		$lead_id = $lead->id;
		$automation_id = $automation->id;
		dispatch(function () use ($lead_id, $automation_id, $email_content) {
			$sent = new \App\Http\Models\AutomationSentEmail;
			$sent->custom_automation_id = $automation_id;
			$sent->email_content = $email_content;
			$sent->lead_id = $lead_id;
			$sent->save();
		})->onQueue("automation-queued-email");
	}

	private function getLeads($automation, $status, $trigger)
	{
		$sub_status_id = $status->sub_status->pluck("id");
		return Lead::whereIn("lead_substatus_id", $sub_status_id)
			->where("updated_at", ">=", $automation->created_at)
			->where("data->email", "!=", "null")
			->whereDoesntHave("automation_sent_emails", function ($q) use ($trigger) {
				$q->whereHas("custom_automation", function ($q)  use ($trigger) {
					$q->where("data->trigger", $trigger);
				});
			})->where("created_at", ">=", $automation->created_at)->get();
	}
}
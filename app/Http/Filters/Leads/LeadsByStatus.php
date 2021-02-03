<?php

namespace App\Http\Filters\Leads;

use  marcusvbda\vstack\Filter;
use App\Http\Models\LeadStatus;

class LeadsByStatus extends Filter
{

	public $component   = "select-filter";
	public $label       = "Status";
	public $index = "status";
	public $_options = [];

	public function __construct()
	{
		$this->options = LeadStatus::selectRaw("id as value,name as label")->get();
		parent::__construct();
	}

	public function apply($query, $value)
	{
		return $query->whereIn("lead_substatus_id", LeadStatus::findOrFail($value)->sub_status()->pluck("id"));
	}
}

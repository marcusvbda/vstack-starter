<?php

namespace App\Http\Filters\Leads;

use  marcusvbda\vstack\Filter;
use App\Http\Models\LeadSubStatus;

class LeadsBySubStatus extends Filter
{

	public $component   = "select-filter";
	public $label       = "Sub Status";
	public $index = "substatus";
	public $_options = [];

	public function __construct()
	{
		$this->options = LeadSubStatus::selectRaw("id as value,name as label")->get();
		parent::__construct();
	}

	public function apply($query, $value)
	{
		return $query->where("lead_substatus_id", $value);
	}
}

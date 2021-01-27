<?php

namespace App\Http\Filters\Leads;

use  marcusvbda\vstack\Filter;
use App\Http\Constants\Leads\Statuses;

class LeadsByStatus extends Filter
{

	public $component   = "select-filter";
	public $label       = "Status";
	public $index = "status";
	public $_options = [];

	public function __construct()
	{
		$this->_options = Statuses::options();
		foreach (Statuses::options() as $key => $value) {
			$this->options[] = (object) ["value" => array_search($key, array_keys($this->_options)) + 1, "label" => $value];
		}
		parent::__construct();
	}

	public function apply($query, $value)
	{
		return $query->where("status", @array_keys($this->_options)[intval($value) - 1]);
	}
}
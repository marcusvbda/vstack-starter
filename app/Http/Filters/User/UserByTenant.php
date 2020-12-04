<?php

namespace App\Http\Filters\User;

use  marcusvbda\vstack\Filter;
use App\Http\Models\Tenant;

class UserByTenant extends Filter
{

	public $component   = "select-filter";
	public $label       = "Tenant";
	public $placeholder = "";
	public $index = "tenant_id";

	public function __construct()
	{
		foreach (Tenant::get() as $row) $this->options[] = (object) ["value" => $row->id, "label" => $row->name];
		parent::__construct();
	}

	public function apply($query, $value)
	{
		return $query->where("tenant_id", $value);
	}
}

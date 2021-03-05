<?php

namespace App\Http\Models;

use marcusvbda\vstack\Models\DefaultModel;

class CustomField extends DefaultModel
{
	protected $table = "custom_fields";
	public $casts = [
		"show_in_list" => "boolean",
		"make_filter" => "boolean",
		"required" => "boolean",
		"options" => "array",
	];

	public function makeFieldName($description)
	{
		return preg_replace('/\s+/', "_", strtolower(preg_replace('/(?<!^)[A-Z]/', '$0', $description)));
	}

	public function setNameAttribute($value)
	{
		$this->attributes["name"] = $value;
		$this->attributes["field"] = $this->makeFieldName($value);
	}
}
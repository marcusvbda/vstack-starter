<?php

namespace App\Http\Filters;

use  marcusvbda\vstack\Filter;

class FilterByCustomFields extends Filter
{

	public $index = "tenant_id";
	public $multiple = true;
	public $field_options = [];

	public function __construct($field)
	{
		$this->label = $field->name;
		$this->index = $field->field;
		switch ($field->type) {
			case "select":
				$this->component = "select-filter";
				foreach ($field->options as $key => $value) {
					$this->field_options[] = $value;
					$this->options[] = (object) ["value" => $key + 1, "label" => $value];
				}
				break;
			default:
				$this->component = "text-filter";
				break;
		}
		parent::__construct();
	}

	public function apply($query, $value)
	{
		switch (@$this->component) {
			case "select-filter":
				$value = $this->field_options[$value - 1];
				break;
		}
		return $query->where("custom_fields->" . $this->index, $value);
	}
}
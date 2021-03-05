<?php

namespace App\Http\Models\Traits;

use App\Http\Models\CustomField;

trait HasCustomFields
{

	public function getCustomFields()
	{
		return  CustomField::where("resource", $this->resource_id)->get()->pluck("field")->toArray();
	}

	public function setAttribute($key, $value)
	{
		if (!in_array($key, $this->getCustomFields())) return parent::setAttribute($key, $value);
		return $this->setCustomField($key, $value);
	}

	public function getAttribute($key)
	{
		if (!in_array($key,   $this->getCustomFields())) return parent::getAttribute($key);
		return $this->getCustomField($key);
	}

	private function setCustomField($index, $value)
	{
		$_data = (object)$this->custom_fields ?? [];
		$_data->{$index} = $value;
		$this->custom_fields = $_data;
	}

	private function getCustomField($index)
	{
		return @$this->custom_fields->{$index};
	}
}
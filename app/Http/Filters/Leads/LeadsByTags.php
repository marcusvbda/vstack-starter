<?php

namespace App\Http\Filters\Leads;

use  marcusvbda\vstack\Filter;
use marcusvbda\vstack\Models\TagRelation;
use App\Http\Models\Lead;
use Auth;

class LeadsByTags extends Filter
{

	public $component   = "select-filter";
	public $label       = "Tags";
	public $placeholder = "";
	public $index = "tags";
	public $multiple = true;

	public function __construct()
	{
		$user = Auth::user();
		$this->options = TagRelation::where("resource_tags_relation.model", Lead::class)
			->join("resource_tags", "resource_tags.id", "=", "resource_tags_relation.resource_tag_id")
			->groupBy("resource_tags_relation.resource_tag_id")
			->select("resource_tags.id as value", "resource_tags.name as label")
			->where("resource_tags.model", Lead::class)
			->where("resource_tags.tenant_id", $user->tenant_id)
			->get();
		parent::__construct();
	}

	public function apply($query, $value)
	{
		$tags = explode(",", $value);
		return $query
			->join("resource_tags_relation", "resource_tags_relation.relation_id", "=", "leads.id")
			->where("resource_tags_relation.model", Lead::class)
			->whereIn("resource_tags_relation.resource_tag_id", $tags);
	}
}
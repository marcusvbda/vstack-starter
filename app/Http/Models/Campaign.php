<?php

namespace App\Http\Models;

use marcusvbda\vstack\Models\DefaultModel;
use App\Http\Models\Scopes\{OrderByScope, PoloScope};
use Carbon\Carbon;
use Illuminate\Http\Request;

class Campaign extends DefaultModel
{
	protected $table = "campaigns";

	public $appends = ["code", "processed_filters"];
	public $dates = ["created_at", "deleted_at", "updated_at", "duedate", "coverage", "active"];
	public $casts = [
		"protected" => "boolean",
		"query_filters" => "json"
	];

	public static function boot()
	{
		parent::boot();
		static::addGlobalScope(new PoloScope(with(new static)->getTable(), true));
		static::addGlobalScope(new OrderByScope(with(new static)->getTable()));
	}

	public function getDurationAttribute()
	{
		$protected = $this->protected;
		if ($protected) {
			$icon = getEnabledIcon($protected);
			return "
				<div class='d-flex flex-row align-items-center'>
					<span class='mr-1'>$icon</span>
					<span>Permanente</span>
				</div>
			";
		}
		$icon = getEnabledIcon($this->is_active);
		$created = @$this->created_at->format("d/m/Y");
		$duedate = @$this->duedate->format("d/m/Y");
		return "
				<div class='d-flex flex-row align-items-center'>
					<span class='mr-1'>$icon</span>
					<span>$created - $duedate</span>
				</div>
			";
	}

	public function getIsActiveAttribute()
	{
		if ($this->protected) return true;
		$duedate = $this->duedate;
		if (!$duedate) return false;
		$duedate = $this->duedate;
		return $this->duedate->startOfDay()->greaterThanOrEqualTo(Carbon::now()->startOfDay());
	}

	public function getFCodeAttribute()
	{
		$code = $this->code;
		$active = $this->is_active;
		$color_class = $active ? "text-success" : "text-danger";
		return "<a class='$color_class' href='/admin/campanhas/$code/leads'><b>$code</b></a>";
	}

	public function getCoverageAttribute()
	{
		$polo_id = @$this->polo_id;
		return $polo_id ? "unique" : "all";
	}

	public function getFCoverageAttribute()
	{
		$coverage = @$this->coverage;
		return $coverage == 'unique' ? "Apenas este polo" : "Todos os polos";
	}

	public function getProcessedFiltersAttribute()
	{
		$_request = new Request();
		$_request->setMethod('POST');
		$filters = ((array) @$this->query_filters ?? []);
		$processed_filters = [];
		foreach (array_keys($filters) as $key) {
			$index = str_replace("filter_", "", $key);
			if ($index == "created_at") {
				$dates = array_map(function ($x) {
					return Carbon::create($x)->format("d/m/Y");
				}, $filters[$key]);
				$processed_filters[$index] = implode(",", $dates);
			} else {
				$processed_filters[$index] = $filters[$key];
			}
		}
		return $processed_filters;
	}

	public function getQueryFiltersRequestTypeAttribute()
	{
		$_request = new Request();
		$_request->setMethod('POST');
		$_request->request->add($this->processed_filters);
		return $_request;
	}
}
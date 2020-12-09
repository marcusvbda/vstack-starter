<?php

namespace App\Http\Models;

use marcusvbda\vstack\Models\DefaultModel;
use App\User;
use App\Http\Models\Scopes\OrderByScope;
use App\Http\Constants\Statuses\CampaignStatus;

class Campaign extends DefaultModel
{
	protected $table = "campaigns";
	// public $cascadeDeletes = [];
	// public $restrictDeletes = [""];

	public $dates = ["starts_at", "ends_at"];
	public $casts = [
		"data" => "object",
	];

	public static function boot()
	{
		parent::boot();
		static::addGlobalScope(new OrderByScope(with(new static)->getTable()));
	}

	public function users()
	{
		return $this->hasMany(User::class);
	}

	public function tenant()
	{
		return $this->belongsTo(Tenant::class);
	}

	public function setStatusAttribute($value)
	{
		$this->attributes["status"] = CampaignStatus::getIndex($value);
	}

	public function getStatusAttribute($value)
	{
		return CampaignStatus::getValue($value);
	}

	public function getPeriodAttribute()
	{
		if (!@$this->starts_at && !@$this->ends_at) return "Campanha permanente";
		return formatDate($this->starts_at, "d/m/Y") . " - " . formatDate($this->ends_at, "d/m/Y");
	}
}
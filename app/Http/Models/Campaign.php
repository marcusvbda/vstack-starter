<?php

namespace App\Http\Models;

use marcusvbda\vstack\Models\DefaultModel;
use App\User;
use App\Http\Models\Scopes\OrderByScope;

class Campaign extends DefaultModel
{
	protected $table = "campaigns";
	// public $cascadeDeletes = [];
	// public $restrictDeletes = [""];

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
}
<?php

namespace App\Http\Models;

use marcusvbda\vstack\Models\DefaultModel;
use App\User;
use App\Http\Models\Scopes\OrderByScope;

class Tenant extends DefaultModel
{
	protected $table = "tenants";
	// public $cascadeDeletes = [];
	public $restrictDeletes = ["users"];

	public $appends = ["code"];

	public $casts = [
		"data" => "object",
	];

	public static function boot()
	{
		parent::boot();
		static::addGlobalScope(new OrderByScope(with(new static)->getTable()));
	}

	public static function hasTenant() //default true
	{
		return false;
	}

	public function users()
	{
		return $this->hasMany(User::class);
	}

	public function polos()
	{
		return $this->hasMany(Polo::class);
	}
}
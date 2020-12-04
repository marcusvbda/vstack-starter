<?php

namespace App\Http\Models;

use Spatie\Permission\Models\Permission as RootPermissionModel;
use App\Http\Models\Scopes\OrderByScope;

class Permission extends RootPermissionModel
{
	protected $table = "permissions";

	public $appends = ["f_created_at_for_humans"];

	public function getFCreatedAtForHumansAttribute()
	{
		if (!$this->created_at) return;
		return $this->created_at->diffForHumans();
	}

	public static function boot()
	{
		parent::boot();
		static::addGlobalScope(new OrderByScope(with(new static)->getTable()));
	}
}
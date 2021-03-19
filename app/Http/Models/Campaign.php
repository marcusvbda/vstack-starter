<?php

namespace App\Http\Models;

use marcusvbda\vstack\Models\DefaultModel;
use App\Http\Models\Scopes\{OrderByScope, PoloScope};

class Campaign extends DefaultModel
{
	protected $table = "campaigns";

	public $appends = ["code"];
	public $casts = [
		"protected" => "boolean"
	];

	public static function boot()
	{
		parent::boot();
		static::addGlobalScope(new PoloScope(with(new static)->getTable(), true));
		static::addGlobalScope(new OrderByScope(with(new static)->getTable()));
	}
}
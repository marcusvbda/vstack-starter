<?php

namespace App\Http\Models\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Auth;

class PoloScope implements Scope
{
	private $polo = null;
	private $table = "";

	public function __construct($table)
	{
		$this->table = $table;
		if (Auth::check()) $this->polo = Auth::user()->polo;
	}

	public function apply(Builder $builder, Model $model)
	{
		if (@$this->polo->id) {
			@$builder->where($this->table . ".polo_id", $this->polo->id);
		}
	}
}
<?php

namespace App\Http\Models\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Auth;

class RoleClientScope implements Scope
{
	public function apply(Builder $builder, Model $model)
	{
		if (Auth::check()) @$builder->where("name", "!=", "super-admin")->where("id", "!=", Auth::user()->roles[0]->id);
	}
}
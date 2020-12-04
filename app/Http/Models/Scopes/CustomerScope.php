<?php

namespace App\Http\Models\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class CustomerScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        @$builder->groupBy("customer->name")->groupBy("customer->email");
    }
}

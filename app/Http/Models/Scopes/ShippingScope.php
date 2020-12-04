<?php

namespace App\Http\Models\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ShippingScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        // @$builder->whereNull("payment_ref");
    }
}

<?php

namespace App\Http\Models\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Models\{EventSubscription, Tenant, Payment};
use DB;

class CallcenterScope implements Scope
{
	private $target = "";
	private $user = null;

	public function __construct($target, $user)
	{
		$this->target = @explode("\\", $target)[3];
		$this->user = $user;
	}

	public function apply(Builder $builder, Model $model)
	{
		return $this->{'applyScope' . $this->target}($builder);
	}

	protected function applyScopePayment($builder)
	{
		$user = $this->user;
		return @$builder->join("call_center_products", "call_center_products.product_id", "payments.product_id")
			->where(function ($q) use ($user) {
				return $q->where("call_center_products.seller_id", $user->tenant_id)
					->orWhere("payments.tenant_id", $user->tenant_id);
			});
	}

	protected function applyScopeOrder($builder)
	{
		$user = $this->user;
		return @$builder->join("payments", "payments.id", "orders.payment_id")
			->join("call_center_products", "call_center_products.product_id", "payments.product_id")
			->where(function ($q) use ($user) {
				return $q->where("call_center_products.seller_id", $user->tenant_id)
					->orWhere("orders.tenant_id", $user->tenant_id);
			});
	}

	protected function applyScopeLink($builder)
	{
		$user = $this->user;
		return @$builder->join("call_center_products", "call_center_products.product_id", "links.product_id")
			->where(function ($q) use ($user) {
				return $q->where("call_center_products.seller_id", $user->tenant_id)
					->orWhere("links.tenant_id", $user->tenant_id);
			});
	}

	protected function applyScopeAccessLink($builder)
	{
		$user = $this->user;
		return @$builder->join("links", "links.id", "access_link.link_id")
			->join("call_center_products", "call_center_products.product_id", "links.product_id")
			->where(function ($q) use ($user) {
				return $q->where("call_center_products.seller_id", $user->tenant_id)
					->orWhere("access_link.tenant_id", $user->tenant_id);
			});
	}

	protected function applyScopeCustomer($builder)
	{
		$user = $this->user;
		return @$builder->join("orders", "orders.customer_id", "customers.id")
			->join("payments", "payments.id", "orders.payment_id")
			->join("call_center_products", "call_center_products.product_id", "payments.product_id")
			->where(function ($q) use ($user) {
				return $q->where("call_center_products.seller_id", $user->tenant_id)
					->orWhere("customers.tenant_id", $user->tenant_id);
			})
			->select("customers.*")
			->groupBy("customers.id");
	}
}
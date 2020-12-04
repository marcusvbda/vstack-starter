<?php

namespace App\Http\Models;

use Spatie\Permission\Models\Role as RootRoleModel;
use marcusvbda\vstack\Models\Scopes\TenantScope;
use marcusvbda\vstack\Models\Observers\TenantObserver;
use App\Http\Models\Scopes\RoleClientScope;
use marcusvbda\vstack\Models\Traits\hasCode;
use App\Http\Models\Scopes\OrderByScope;

class Role extends RootRoleModel
{
	use hasCode;
	protected $table = "roles";

	public $appends = ["code", "f_created_at_for_humans", "processed_permissions", "f_access_level", "access_level"];


	public static function boot()
	{
		parent::boot();
		static::addGlobalScope(new OrderByScope(with(new static)->getTable()));
		static::observe(new TenantObserver());
		static::addGlobalScope(new TenantScope());
		static::addGlobalScope(new RoleClientScope());
	}

	public function getCodeAttribute()
	{
		return \Hashids::encode($this->id);
	}

	public function getFCreatedAtForHumansAttribute()
	{
		if (!$this->created_at) return;
		return $this->created_at->diffForHumans();
	}

	public function getRules()
	{
		$id = @$this->id ? $this->id : null;
		return [
			'permissions' => 'required',
			'description' => ['required', function ($attribute, $value, $fail) use ($id) {
				if (Role::where("name", $value)->where("id", "!=", $id)->count() > 0) $fail('Este Grupo de acesso já existe');
			}],
		];
	}

	public function getProcessedPermissionsAttribute()
	{
		if (!@$this->id) return;
		$results = [];
		foreach (Permission::get() as $permission) {
			$results[$permission->name] = $this->hasPermissionTo($permission);
		}
		return (object) $results;
	}

	public function permissions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
	{
		return $this->belongsToMany(
			config('permission.models.permission'),
			config('permission.table_names.role_has_permissions'),
			'role_id',
			'permission_id'
		)->where("role_id", $this->id);
	}

	public function getAccessLevelAttribute()
	{
		$total = Permission::count();
		$qty = $this->permissions()->count();
		$percentage = round(($qty * 100) / $total);
		return intval($percentage);
	}

	public function getFAccessLevelAttribute()
	{
		$percentage = $this->access_level;
		if ($percentage <= 11)
			$type = "danger";
		if (($percentage > 11) && ($percentage <= 50))
			$type = "primary";
		if (($percentage > 51) && ($percentage <= 99))
			$type = "warning";
		if ($percentage == 100)
			$type = "success";
		return "<small class='f-12 badge badge-$type'>$percentage% Liberado</small>";
	}

	public function tenant()
	{
		return $this->belongsTo(Tenant::class);
	}
}
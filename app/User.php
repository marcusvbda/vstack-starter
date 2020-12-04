<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use marcusvbda\vstack\Models\Traits\hasCode;
use Spatie\Permission\Traits\HasRoles;
use Auth;
use App\Http\Models\Tenant;
use marcusvbda\vstack\Models\Scopes\TenantScope;
use marcusvbda\vstack\Models\Observers\TenantObserver;
use App\Http\Models\Scopes\OrderByScope;
use App\Http\Models\Pivots\UserPolo;
use App\Http\Models\{UserNotification, Polo};

class User extends Authenticatable implements MustVerifyEmail
{
	use SoftDeletes, Notifiable, hasCode, HasRoles;
	public $guarded = ['created_at'];
	protected $appends = ['code'];
	protected $hashPassword = false;
	public  $casts = [
		"data" => "json",
	];
	public $relations = [];

	public function __construct($hashPassword = true)
	{
		$this->hashPassword = $hashPassword;
	}

	public static function boot()
	{
		parent::boot();
		static::addGlobalScope(new OrderByScope(with(new static)->getTable()));
		if (Auth::check()) {
			if (!Auth::user()->hasRole(["super-admin"])) {
				static::observe(new TenantObserver());
				static::addGlobalScope(new TenantScope());
			}
		}
	}

	public function getCodeAttribute()
	{
		return \Hashids::encode($this->id);
	}

	public function receivesBroadcastNotificationsOn()
	{
		return 'App.User.' . $this->id;
	}

	public function setPasswordAttribute($val)
	{
		$this->attributes["password"] = bcrypt($val);
	}

	public function tenant()
	{
		return $this->BelongsTo(Tenant::class);
	}

	public function polos()
	{
		if ($this->isSuperAdmin()) return  Polo::where("id", ">", "0");
		return $this->belongsToMany(Polo::class, UserPolo::class, "user_id", "polo_id");
	}

	public function polo()
	{
		return $this->belongsTo(Polo::class);
	}

	public function getRoleNameAttribute()
	{
		return @$this->roles()->first()->name;
	}

	public function isSuperAdmin()
	{
		return  $this->hasRole(['super-admin']);
	}

	public function userNotifications()
	{
		return $this->hasMany(UserNotification::class, "user_id");
	}

	public function getQyNewNotifications()
	{
		return $this->userNotifications()->isNew()->count();
	}
}
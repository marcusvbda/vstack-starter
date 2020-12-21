<?php

namespace App\Http\Models;

use marcusvbda\vstack\Models\DefaultModel;
use App\User;
use App\Http\Models\Scopes\OrderByScope;
use App\Http\Constants\Statuses\LeadStatus;

class Lead extends DefaultModel
{
	protected $table = "leads";
	// public $cascadeDeletes = [];
	// public $restrictDeletes = [""];

	public $casts = [
		"conversions" => "array",
		"data" => "object",
	];

	public static function boot()
	{
		parent::boot();
		static::addGlobalScope(new OrderByScope(with(new static)->getTable()));
	}

	public function users()
	{
		return $this->hasMany(User::class);
	}

	public function tenant()
	{
		return $this->belongsTo(Tenant::class);
	}

	public function setStatusAttribute($value)
	{
		$this->attributes["status"] = LeadStatus::getIndex($value);
	}

	public function getStatusAttribute($value)
	{
		return LeadStatus::getValue($value);
	}

	public function apiUser()
	{
		return $this->belongsTo(ApiUser::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function getEmailUrlAttribute()
	{
		return "<email-url value='{$this->data->email}'>{$this->data->email}</email-url>";
	}

	public function getPhonesUrlAttribute()
	{
		$html = [];
		foreach ($this->data->phones as $phone)  $html[] = "<email-url value='{$phone}'>{$phone}</email-url>";
		$html = implode('  ', $html);
		return "<div class='d-flex flex-column'>{$html}</div>";
	}

	public function getFCreatedAttribute()
	{
		$created = $this->created_at;
		$formated = formatDate($created);
		$diff = $created->diffForHumans();
		return "
		<div class='d-flex flex-column'>
			<b>{$formated}</b>
			<small>{$diff}</small>
		</div>";
	}

	public function getOriginAttribute()
	{
		return $this->api_user_id ? ApiUser::findOrFail($this->api_user_id)->name : User::findOrFail($this->user_id)->name;
	}
}
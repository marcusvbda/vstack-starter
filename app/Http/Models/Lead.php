<?php

namespace App\Http\Models;

use marcusvbda\vstack\Models\DefaultModel;
use App\User;
use App\Http\Models\Scopes\{OrderByScope, PoloScope};
use Auth;
use Carbon\Carbon;

class Lead extends DefaultModel
{
	protected $table = "leads";
	// public $cascadeDeletes = [];
	// public $restrictDeletes = [""];

	public $casts = [
		"data" => "object",
	];

	public $appends = [
		"code", "name", "f_status", "f_substatus", "email", "profession", "f_last_conversion", "cellphone_number",
		"phone_number", "obs", "f_created_at", "objection", "comment", "interest", "f_status_badge",
		"f_birthdate", "age", "f_last_conversion_date", "api_ref_token", "other_objection", "conversions",
		"tries", "lead_api"
	];

	public static function boot()
	{
		parent::boot();
		static::addGlobalScope(new PoloScope(with(new static)->getTable()));
		static::addGlobalScope(new OrderByScope(with(new static)->getTable()));
		static::creating(function ($model) {
			if (Auth::check()) {
				$user = Auth::user();
				if (!@$model->user_id) $model->user_id = $user->id;
				if (!@$model->polo_id && $user->polo_id) $model->polo_id = $user->polo_id;
			}
			if (!@$model->lead_substatus_id) $model->lead_substatus_id = LeadSubStatus::where("value", "new_contact")->firstOrFail()->id;
		});
	}


	// getters
	public function getLeadApiAttribute()
	{
		return $this->data->lead_api ?? [];
	}

	public function getTriesAttribute()
	{
		return $this->data->tries ?? [];
	}

	public function getConversionsAttribute()
	{
		return $this->data->log ?? [];
	}

	public function getLastConversionAttribute()
	{
		return current($this->conversions);
	}

	public function getFLastConversionDateAttribute()
	{
		$last_conversion = $this->f_last_conversion;
		return "Última Conversão : " . $last_conversion;
	}

	public function getFStatusBadgeAttribute()
	{
		$status = $this->substatus->status->name;
		return "<small class='status-color {$status}'>{$status}</small>";
	}

	public function getBtnConversionAttribute()
	{
		$code = $this->code;
		$status = $this->f_status_badge;
		$f_substatus = $this->substatus->name;
		return "
			<div class='d-flex flex-column align-items-center justify-content-center'>
				{$status}
				<a href='/admin/funil-de-conversao/{$code}/converter' class='el-button el-button--default el-button--small is-round my-2'>Converter</a>
				<small>{$f_substatus}</small>
			</div>
		";
	}

	public function getStatusAttribute()
	{
		return $this->substatus->status;
	}

	public function substatus()
	{
		return $this->belongsTo(LeadSubstatus::class, "lead_substatus_id");
	}

	public function getFStatusAttribute()
	{
		return $this->status->name;
	}

	public function getFSubStatusAttribute()
	{
		return $this->substatus->name;
	}

	public function getEmailUrlAttribute()
	{
		return "<email-url type='email' value='{$this->data->email}'>{$this->data->email}</email-url>";
	}

	public function getPhonesUrlAttribute()
	{
		$html = [];
		$cell = $this->cellphone_number;
		$phone = $this->phone_number;
		if (@$phone) $html[] = "<span>{$phone}</span>";
		if (@$cell) $html[] = "<email-url type='wpp'  value='{$cell}'>{$cell}</email-url>";
		$html = implode('  ', $html);
		return "<div class='d-flex flex-column text-center'>{$html}</div>";
	}

	public function getFCreatedAtAttribute()
	{
		$created = $this->created_at;
		return formatDate($created);
	}

	public function getFCompleteCreatedAttribute()
	{
		$created = $this->created_at;
		$formated = $this->f_created_at;
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

	public function getNameAttribute()
	{
		return @$this->data->name;
	}

	public function getBirthdateAttribute()
	{
		return @$this->data->birthdate;
	}

	public function getFBirthdateAttribute()
	{
		$birthdate = @$this->birthdate;
		if (!$birthdate) return;
		return Carbon::create($birthdate)->format("d/m/Y");
	}

	public function getAgeAttribute()
	{
		$birthdate = @$this->birthdate;
		if (!$birthdate) return;
		return Carbon::create($birthdate)->age;
	}

	public function getObjectionAttribute()
	{
		return @$this->data->objection;
	}

	public function getOtherObjectionAttribute()
	{
		return @$this->data->other_objection;
	}

	public function getCommentAttribute()
	{
		return $this->data->comment;
	}

	public function getFLastConversionAttribute()
	{
		$last_conversion = $this->last_conversion;
		if (!@$last_conversion->data) return "Nunca Convertido";
		return $last_conversion->data . " - " . $last_conversion->hora;
	}

	public function getCellphoneNumberAttribute()
	{
		return @$this->data->phones[0];
	}

	public function getPhoneNumberAttribute()
	{
		return @$this->data->phones[1];
	}

	public function getEmailAttribute()
	{
		return @$this->data->email;
	}

	public function getObsAttribute()
	{
		return @$this->data->obs;
	}

	public function getCityAttribute()
	{
		return @$this->data->city;
	}

	public function getZipcodeAttribute()
	{
		return @$this->data->zipcode;
	}

	public function getDistrictAttribute()
	{
		return @$this->data->district;
	}

	public function getAddressNumberAttribute()
	{
		return @$this->data->address_number;
	}

	public function getProfessionAttribute()
	{
		return @$this->data->profession;
	}

	public function getComplementaryAttribute()
	{
		return @$this->data->complementary;
	}

	public function getInterestAttribute()
	{
		return @$this->data->interest;
	}

	public function getApiRefTokenAttribute()
	{
		return @$this->data->api_ref_token;
	}
	// getters

	// setters
	public function setApiRefTokenAttribute($value)
	{
		$this->setDataValue("api_ref_token", $value);
	}

	public function setBirthdateAttribute($value)
	{
		$this->setDataValue("birthdate", $value);
	}

	public function setEmailAttribute($value)
	{
		$this->setDataValue("email", $value);
	}

	public function setPhoneNumberAttribute($value)
	{
		$this->setDataValue("phones", [$this->cellphone_number, $value]);
	}

	public function setCellphoneNumberAttribute($value)
	{
		$this->setDataValue("phones", [$value, $this->phone_number]);
	}

	public function setNameAttribute($value)
	{
		$this->setDataValue("name", $value);
	}

	public function setProfessionAttribute($value)
	{
		$this->setDataValue("profession", $value);
	}

	public function setCommentAttribute($value)
	{
		$this->setDataValue("comment", $value);
	}

	public function setObsAttribute($value)
	{
		$this->setDataValue("obs", $value);
	}

	public function setCityAttribute($value)
	{
		$this->setDataValue("city", $value);
	}

	public function setZipcodeAttribute($value)
	{
		$this->setDataValue("zipcode", $value);
	}

	public function setDistrictAttribute($value)
	{
		$this->setDataValue("district", $value);
	}

	public function setComplementaryAttribute($value)
	{
		$this->setDataValue("complementary", $value);
	}

	public function setAddressNumberAttribute($value)
	{
		$this->setDataValue("address_number", $value);
	}

	public function setInterestAttribute($value)
	{
		$this->setDataValue("interest", $value);
	}

	protected function setDataValue($field, $value)
	{
		$_data = @$this->data ?? (object)[];
		$_data->{$field} = $value;
		$this->data = $_data;
	}
	// setters

	// relations
	public function users()
	{
		return $this->hasMany(User::class);
	}

	public function tenant()
	{
		return $this->belongsTo(Tenant::class);
	}

	public function apiUser()
	{
		return $this->belongsTo(ApiUser::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function polo()
	{
		return $this->belongsTo(Polo::class);
	}
	// relations
}

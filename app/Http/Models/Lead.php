<?php

namespace App\Http\Models;

use marcusvbda\vstack\Models\DefaultModel;
use App\User;
use App\Http\Models\Scopes\{OrderByScope, PoloScope};
use App\Http\Constants\Leads\Statuses;
use Auth;
use Illuminate\Support\Arr;

class Lead extends DefaultModel
{
	protected $table = "leads";
	// public $cascadeDeletes = [];
	// public $restrictDeletes = [""];

	public $casts = [
		"conversions" => "array",
		"data" => "object",
	];

	public $appends = ["code", "name", "f_status", "email", "profession", "f_last_conversion", "cellphone_number", "phone_number", "obs", "f_created_at"];

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
			$model->conversions = [];
		});
	}

	public function getFLastConversionAttribute()
	{
		return "01/01/1992 - 21:52:10";
	}

	public function users()
	{
		return $this->hasMany(User::class);
	}

	public function tenant()
	{
		return $this->belongsTo(Tenant::class);
	}

	public function getLastConversionAttribute()
	{
		return current($this->conversions ?? []);
	}

	public function getFLastConversionDateAttribute()
	{
		$last_conversion = $this->f_last_conversion;
		if (!$last_conversion) return "Nunca Convertido";
		return "Última Conversão : " . $last_conversion;
	}

	public function getBtnConversionAttribute()
	{
		$code = $this->code;
		$status = $this->f_status;
		$f_last_conversion_date = $this->f_last_conversion_date;
		return "
			<div class='d-flex flex-column align-items-center justify-content-center'>
				<small class='status-color {$status}'>{$status}</small>
				<a href='/admin/funil-de-conversao/{$code}' class='el-button el-button--default el-button--small is-round my-2'>Converter</a>
				<small>{$f_last_conversion_date}</small>
			</div>
		";
	}

	public function setStatusAttribute($value)
	{
		$this->attributes["status"] = Statuses::getIndex($value);
	}

	public function getFStatusAttribute()
	{
		return Statuses::getValue($this->status);
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

	public function polo()
	{
		return $this->belongsTo(Polo::class);
	}

	public function getOriginAttribute()
	{
		return $this->api_user_id ? ApiUser::findOrFail($this->api_user_id)->name : User::findOrFail($this->user_id)->name;
	}

	public function getNameAttribute()
	{
		return @$this->data->name;
	}

	public function setEmailAttribute($value)
	{
		$this->setDataValue("email", $value);
	}

	public function getCellphoneNumberAttribute()
	{
		return @$this->data->phones[0];
	}

	public function getPhoneNumberAttribute()
	{
		return @$this->data->phones[1];
	}

	public function setPhoneNumberAttribute($value)
	{
		$this->setDataValue("phones", [$value, $this->cellphone_number]);
	}

	public function setCellphoneNumberAttribute($value)
	{
		$this->setDataValue("phones", [$this->phone_number, $value]);
	}

	public function getEmailAttribute()
	{
		return @$this->data->email;
	}

	public function setNameAttribute($value)
	{
		$this->setDataValue("name", $value);
	}

	public function getProfessionAttribute()
	{
		return @$this->data->profession;
	}

	public function setProfessionAttribute($value)
	{
		$this->setDataValue("profession", $value);
	}

	public function getObsAttribute()
	{
		return @$this->data->obs;
	}

	public function setObsAttribute($value)
	{
		$this->setDataValue("obs", $value);
	}

	public function getCityAttribute()
	{
		return @$this->data->city;
	}

	public function setCityAttribute($value)
	{
		$this->setDataValue("city", $value);
	}

	public function getZipcodeAttribute()
	{
		return @$this->data->zipcode;
	}

	public function setZipcodeAttribute($value)
	{
		$this->setDataValue("zipcode", $value);
	}

	public function getDistrictAttribute()
	{
		return @$this->data->district;
	}

	public function setDistrictAttribute($value)
	{
		$this->setDataValue("district", $value);
	}

	public function getComplementaryAttribute()
	{
		return @$this->data->complementary;
	}

	public function setComplementaryAttribute($value)
	{
		$this->setDataValue("complementary", $value);
	}

	public function getAddressNumberAttribute()
	{
		return @$this->data->address_number;
	}

	public function setAddressNumberAttribute($value)
	{
		$this->setDataValue("address_number", $value);
	}

	public function getInterestAttribute()
	{
		return @$this->data->interest;
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
}
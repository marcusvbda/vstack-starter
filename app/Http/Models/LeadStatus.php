<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Models\Scopes\{OrderByScope};

class LeadStatus extends Model
{
	public $guarded = ["created_at"];
	public $cascadeDeletes = [];
	public $restrictDeletes = [];
	protected $table = "lead_statuses";

	public $casts = [
		"data" => "object"
	];

	public static function boot()
	{
		parent::boot();
		static::addGlobalScope(new OrderByScope(with(new static)->getTable(), "seq"));
	}

	public function sub_status()
	{
		return $this->hasMany(LeadSubstatus::class, "lead_status_id");
	}

	public function addSubtatus($data)
	{
		$data["lead_status_id"] = $this->id;
		LeadSubstatus::create($data);
	}
}

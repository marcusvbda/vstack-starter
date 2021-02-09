<?php

namespace App\Http\Models;

use marcusvbda\vstack\Models\DefaultModel;

class LeadAnswer extends DefaultModel
{
	protected $table = "lead_answers";
	// public $cascadeDeletes = [];
	// public $restrictDeletes = [];
	// public $relations = []; //add relations that you want to load in resource field (ajax)
	// public static function hasTenant() //default true
	// {
	//     return true;
	// }
}
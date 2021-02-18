<?php
namespace App\Http\Models;
use marcusvbda\vstack\Models\DefaultModel;
class Automation extends DefaultModel
{
    protected $table = "automations";
    // public $cascadeDeletes = [];
    // public $restrictDeletes = [];
    // public $relations = []; //add relations that you want to load in resource field (ajax)
    // public static function hasTenant() //default true
    // {
    //     return true;
    // }
}
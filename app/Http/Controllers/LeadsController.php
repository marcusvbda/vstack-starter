<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Http\Models\{Lead};

class LeadsController extends Controller
{
	public function create()
	{
		return view("admin.leads.crud");
	}
}
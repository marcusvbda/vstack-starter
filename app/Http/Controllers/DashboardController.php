<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Models\Polo;
use Auth;

class DashboardController extends Controller
{
	private $divisor = 5;

	public function __construct()
	{
		// dd(request("timezone"));
	}

	public function index()
	{
		return view('admin.index');
	}

	public function getData($action, Request $request)
	{
		return $this->{$action}($request);
	}

	protected function new_polos(Request $request)
	{
		$qty_divides = $this->getDotDivide($request);
		$dates = array_map(function ($date) {
			return Carbon::create($date);
		}, $request["date_range"]);
		$total =  Polo::whereDate("created_at", ">=", $dates[0])->whereDate("created_at", "<=", $dates[1])->count();
		$qty =  0;
		$trend = "keep";
		$data = [
			"qty" => $total,
			"trend" => $trend,
			"rows" => ["Até " . $dates[1]->format("d/m/Y") => $total]
		];
		for ($i = 1; $i <= $this->divisor; $i++) {
			$dates[1] = $dates[1]->subDays($i * $qty_divides);
			$new_qty =  Polo::whereDate("created_at", ">=", $dates[0])->whereDate("created_at", "<=", $dates[1])->count();
			$data["rows"]["Até " . $dates[1]->format("d/m/Y")] = $new_qty;
			$trend = $this->getTrend($qty, $new_qty);
			$qty = $new_qty;
		}
		$data["rows"] = array_reverse($data["rows"]);
		return $data;
	}

	protected function new_leads(Request $request)
	{
		$qty =  rand(0, 15);
		$trend = "up";
		if ($qty < 5) $trend = "down";
		if ($qty >= 5 && $qty < 10) $trend = "keep";
		if ($qty > 10 && $qty <= 15) $trend = "up";
		return [
			"qty" => rand(0, 15),
			"trend" => $trend,
			"rows" => [
				"a" => rand(0, 15),
				"b" => rand(0, 15),
				"c" => rand(0, 15),
				"d" => rand(0, 15),
				"e" => rand(0, 15),
				"f" => rand(0, 15),
				"g" => rand(0, 15),
			]
		];
	}

	private function getDotDivide(Request $request)
	{
		$date_range = $request['date_range'];
		$diff = Carbon::create($date_range[1])->diffInDays($date_range[0]);
		return $diff <= 0 ? 1 : $diff / $this->divisor;
	}

	private function getTrend($qty, $new_qty)
	{
		if ($new_qty > $qty) return "up";
		if ($new_qty < $qty) return "down";
		return "keep";
	}
}
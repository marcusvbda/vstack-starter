<?php

namespace App\Http\Actions\Leads;

use  marcusvbda\vstack\Action;
use Illuminate\Http\Request;
use App\Http\Models\Polo;

class TestAction extends Action
{
	public $id = "action-test";
	public $run_btn = "Executar";
	public $title = "Ação de Teste";
	public $message = "Preencha corretamente os inputs e clique em prosseguir para executar a ação";

	public function inputs()
	{
		return [
			["title" => 'Campo 1', "id" => "field_id", "type" => "text", "required" => false],
			["title" => 'Campo 2', "id" => "check_teste", "type" => "checkbox"],
			["title" => 'Campo 3', "id" => "textarea", "type" => "textarea", "rows" => 5, "required" => false],
			["title" => 'Polo', "id" => "polo_id", "type" => "select", "required" => true, "options" =>  Polo::selectRaw("id as value, name as label")->get(), "multiple" => true],
		];
	}

	public function handler(Request $request)
	{
		return ['success' => true];
	}
}
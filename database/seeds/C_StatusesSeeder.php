<?php

use Illuminate\Database\Seeder;
use App\Http\Models\{
	LeadStatus,
	LeadSubstatus
};

class C_StatusesSeeder extends Seeder
{
	public function run()
	{
		DB::statement('SET AUTOCOMMIT=0;');
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		$this->createStatuses();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
		DB::statement('SET AUTOCOMMIT=1;');
		DB::statement('COMMIT;');
	}

	private function createStatuses()
	{
		LeadSubstatus::truncate();
		LeadStatus::truncate();
		$unqualified = LeadStatus::create([
			"seq"  => 0,
			"value" => "unqualified",
			"name" => "Não Qualificado",
		]);
		$unqualified->addSubtatus([
			"seq"  => 0,
			"value" => "canceled",
			"name" => "Cancelado",
		]);


		$waiting = LeadStatus::create([
			"seq"  => 1,
			"value" => "waiting",
			"name" => "Aguardando",
		]);
		$waiting->addSubtatus([
			"seq"  => 0,
			"value" => "new_contact",
			"name" => "Aguardando Contato",
		]);
		$waiting->addSubtatus([
			"seq"  => 1,
			"value" => "schedule",
			"name" => "Contato Agendado",
		]);
		$waiting->addSubtatus([
			"seq"  => 1,
			"value" => "waiting_with_objection",
			"name" => "Aguardando Com Objeçao",
		]);
		$waiting->addSubtatus([
			"seq"  => 1,
			"value" => "possible_non_qualified",
			"name" => "Possivelmente Não Qualificado",
		]);

		$oportunity = LeadStatus::create([
			"seq"  => 2,
			"value" => "oportunity",
			"name" => "Oportunidade",
		]);
		$oportunity->addSubtatus([
			"seq"  => 0,
			"value" => "has_interest",
			"name" => "Interessado",
		]);
		$oportunity->addSubtatus([
			"seq"  => 0,
			"value" => "has_interest_with_objection",
			"name" => "Interessado Condicional",
		]);

		$qualified = LeadStatus::create([
			"seq"  => 3,
			"value" => "qualified",
			"name" => "Qualificado",
		]);
		$qualified->addSubtatus([
			"seq"  => 0,
			"value" => "test",
			"name" => "Vestibular Agendado",
		]);

		$customer = LeadStatus::create([
			"seq"  => 4,
			"value" => "customer",
			"name" => "Convertido",
		]);
		$customer->addSubtatus([
			"seq"  => 0,
			"value" => "test_done",
			"name" => "Vestibular Realizado",
		]);
		$customer->addSubtatus([
			"seq"  => 1,
			"value" => "registration_done",
			"name" => "Matricula Realizada",
		]);
	}
}
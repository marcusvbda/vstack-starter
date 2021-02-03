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
			"seq"  => 1,
			"value" => "waiting_info",
			"name" => "Aguardando Informação",
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
		$qualified->addSubtatus([
			"seq"  => 1,
			"value" => "waiting_test",
			"name" => "Aguardando Agendamento Vestibular",
		]);
		$qualified->addSubtatus([
			"seq"  => 2,
			"value" => "waiting_doc",
			"name" => "Documentação Pendente",
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

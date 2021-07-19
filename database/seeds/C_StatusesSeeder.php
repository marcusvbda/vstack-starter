<?php

use Illuminate\Database\Seeder;
use App\Http\Models\{
	Status,
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
		Status::truncate();
		Status::create([
			"seq"  => 0,
			"value" => "canceled",
			"name" => "Cancelado",
		]);
		Status::create([
			"seq"  => 1,
			"value" => "schedule",
			"name" => "Contato Agendado",
		]);
		Status::create([
			"seq"  => 2,
			"value" => "waiting",
			"name" => "Aguardando",
		]);
		Status::create([
			"seq"  => 3,
			"value" => "objection",
			"name" => "Com Objeçao",
		]);
		Status::create([
			"seq"  => 4,
			"value" => "schedule_test",
			"name" => "Vestibular Agendado",
		]);
		Status::create([
			"seq"  => 5,
			"value" => "schedule_done",
			"name" => "Vestibular Realizado",
		]);
		Status::create([
			"seq"  => 6,
			"value" => "finished",
			"name" => "Matriculado",
		]);
	}
}
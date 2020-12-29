<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\{Role, Permission};

class A_AclSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		$this->createPermissions();
		$this->createRoles();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	}

	private function createPermissions()
	{
		DB::table("permissions")->truncate();
		Cache::flush('spatie.permission.cache');
		Permission::create(["group" => "Campanhas", "name" => "viewlist-leads", "description" => "Ver Listagem de Leads"]);
		Permission::create(["group" => "Campanhas", "name" => "edit-leads", "description" => "Editar Leads"]);
		Permission::create(["group" => "Campanhas", "name" => "destroy-leads", "description" => "Excluir Leads"]);
		Permission::create(["group" => "Campanhas", "name" => "view-leads-report", "description" => "Ver Relatório de Leads"]);
	}

	private function createRoles()
	{
		DB::table("roles")->truncate();
		DB::table("model_has_roles")->truncate();
		DB::table("role_has_permissions")->truncate();
		Cache::flush('spatie.role.cache');
		$role = Role::create(["name" => "super-admin", "description" => "Super Administrador", "tenant_id" => 1]);
		$role = Role::create(["name" => "admin", "Description" => "Administrador", "tenant_id" => 1]);
		$role->givePermissionTo(Permission::all());
		$role = Role::create(["name" => "operador", "Description" => "Operador", "tenant_id" => 1]);
		$role->givePermissionTo(Permission::where(function ($q) {
			$q->where("name", "like", "%operar%")->orWhere("name", "like", "%viewlist%");
		})->get());
	}
}
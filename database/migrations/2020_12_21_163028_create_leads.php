<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeads extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('leads', function (Blueprint $table) {
			$table->charset = 'utf8mb4';
			$table->collation = 'utf8mb4_unicode_ci';
			$table->engine = 'InnoDB';
			$table->bigIncrements('id');
			$table->jsonb('data');
			$table->unsignedBigInteger('lead_substatus_id');
			$table->foreign('lead_substatus_id')
				->references('id')
				->on('lead_substatuses');
			$table->unsignedBigInteger('api_user_id')->nullable();
			$table->foreign('api_user_id')
				->references('id')
				->on('api_users');
			$table->unsignedBigInteger('user_id')->nullable();
			$table->foreign('user_id')
				->references('id')
				->on('users');
			$table->unsignedBigInteger('tenant_id')->nullable();
			$table->foreign('tenant_id')
				->references('id')
				->on('tenants');
			$table->unsignedBigInteger('polo_id')->nullable();
			$table->foreign('polo_id')
				->references('id')
				->on('polos');
			$table->softDeletes();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('leads');
	}
}

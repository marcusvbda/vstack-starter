<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomFields extends Migration
{
	public function up()
	{
		Schema::create('custom_fields', function (Blueprint $table) {
			$table->charset = 'utf8mb4';
			$table->collation = 'utf8mb4_unicode_ci';
			$table->engine = 'InnoDB';
			$table->bigIncrements('id');
			$table->string('name');
			$table->string('card');
			$table->string('description')->nullable();
			$table->string('resource');
			$table->string('field');
			$table->string('type');
			$table->boolean('make_filter')->default(true);
			$table->boolean('show_in_report')->default(true);
			$table->boolean('show_in_list')->default(false);
			$table->boolean('required')->default(true);
			$table->longText('options')->nullable();
			$table->unsignedBigInteger('tenant_id');
			$table->foreign('tenant_id')
				->references('id')
				->on('tenants')
				->onDelete('restrict');
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
		Schema::dropIfExists('custom_fields');
	}
}
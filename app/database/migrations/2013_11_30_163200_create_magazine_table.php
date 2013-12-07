<?php

use Illuminate\Database\Migrations\Migration;

class CreateMagazineTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('magazine', function($table) {
			$table->increments('id');
			$table->integer('category_id');
			$table->string('issue',100);
			$table->string('magazine_name', 250);
			$table->string('magazine_slug', 250);
			$table->string('issue_date', 100);
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
		Schema::drop('magazine');
	}

}
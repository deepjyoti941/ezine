<?php

use Illuminate\Database\Migrations\Migration;

class MagazineCategory extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('magazine_category', function($table) {
			$table->increments('id');
			$table->string('category_name', 250);
			$table->string('category_slug', 250);
			//$table->string('', 100);
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
		Schema::drop('magazine_category');
	}

}
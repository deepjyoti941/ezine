<?php

use Illuminate\Database\Migrations\Migration;

class CreateMagazinePdfTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('magazine_pdf', function($table) {
			$table->increments('id');
			$table->integer('magazine_id');
			$table->string('pdf_path', 100);
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
		Schema::drop('magazine_pdf');

	}

}
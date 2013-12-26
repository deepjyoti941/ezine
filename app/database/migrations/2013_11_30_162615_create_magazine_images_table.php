<?php

use Illuminate\Database\Migrations\Migration;

class CreateMagazineImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('magazine_images', function($table) {
			$table->increments('id');
			$table->integer('magazine_id');
			$table->string('img_path', 100);
			$table->string('img_thumb_path' , 100);
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
		chema::drop('magazine_images');

	}

}
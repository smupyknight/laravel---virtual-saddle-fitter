<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDrawingFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('drawing_files', function(Blueprint $table) {
		    $table->increments('id');
		    $table->integer('fit_check_id')->unsigned();
		    $table->string('filename');
		    $table->string('original_filename');
		    $table->integer('size')->unsigned();
		    $table->datetime('created_at');
		    $table->datetime('updated_at');

		    $table->foreign('fit_check_id')->references('id')->on('fitchecks')->onDelete('cascade');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::drop('drawing_files');
    }
}

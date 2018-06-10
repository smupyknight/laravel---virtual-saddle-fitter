<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSaddlesPanelTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
	{
		DB::statement("ALTER TABLE saddles CHANGE `panel_type` `panel_type` ENUM('Flock', 'Cair', 'Flair', 'Foam', 'Felt', 'Latex', 'Other')");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement("ALTER TABLE saddles CHANGE `panel_type` `panel_type` ENUM('Flock', 'Cair', 'Flair', 'Foam', 'Felt', 'Latex')");
	}
}
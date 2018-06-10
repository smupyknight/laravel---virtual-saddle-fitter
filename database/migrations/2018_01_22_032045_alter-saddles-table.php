<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSaddlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	DB::statement("ALTER TABLE saddles CHANGE `gullet_size` `gullet_size` ENUM('XXW', 'XW/XXW', 'XW', 'W/XW', 'W', 'M/W', 'M', 'N/M', 'N')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    DB::statement("ALTER TABLE saddles CHANGE `gullet_size` `gullet_size` ENUM('n', 'nm. m', 'mw.w.xw.wxw.xww.xxw')");
    }
}

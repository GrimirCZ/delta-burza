<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropHolidaysTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('holidays');
    }

    public function down()
    {
        Schema::table('holidays', function(Blueprint $table){
            //
        });
    }
}

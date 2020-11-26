<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHolidaysTable extends Migration
{
    public function up()
    {
        Schema::create('holidays', function(Blueprint $table){
            $table->bigIncrements('id');

            $table->date("date");
            $table->string("name")->nullable();
            //

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('holidays');
    }
}

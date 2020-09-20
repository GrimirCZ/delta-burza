<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Exhibition extends Migration
{
    public function up()
    {
        Schema::create('exhibitions', function(Blueprint $table){
            $table->bigIncrements('id');

            $table->string("name");
            $table->string("city");
            $table->date("date");
            $table->foreignId("district_id")->constrained();
            //

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exhibition');
    }
}

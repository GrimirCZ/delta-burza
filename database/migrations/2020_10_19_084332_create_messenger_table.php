<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessengerTable extends Migration
{
    public function up()
    {
        Schema::create('messengers', function(Blueprint $table){
            $table->bigIncrements('id');

            $table->string("type");
            $table->json("data"); // to hold messenger specific information like school_id
            //

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('messenger');
    }
}

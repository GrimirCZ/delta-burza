<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Registration extends Migration
{
    public function up()
    {
        Schema::create('registrations', function(Blueprint $table){
            $table->bigIncrements('id');

            $table->foreignId("school_id")->constrained();
            $table->foreignId("exhibition_id")->constrained();

            $table->string("morning_event");
            $table->string("evening_event");

            $table->boolean("is_disabled")->default(false);
            //

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('registrations');
    }
}

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
            $table->string("morning_event_start")->default("8:00");
            $table->string("morning_event_end")->default("12:00");

            $table->string("evening_event");
            $table->string("evening_event_start")->default("18:00");
            $table->string("evening_event_end")->default("21:00");

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

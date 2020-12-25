<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToExhibitions extends Migration
{
    public function up()
    {
        Schema::table('exhibitions', function(Blueprint $table){
            $table->boolean("has_test_event")->default(true);
            $table->boolean("has_morning_event")->default(true);
            $table->boolean("has_evening_event")->default(true);
            $table->boolean("has_chat")->default(true);

            $table->string("test_event_start")->default("08:00");
            $table->string("test_event_end")->default("08:45");

            $table->string("morning_event_start")->default("08:00");
            $table->string("morning_event_end")->default("12:00");

            $table->string("evening_event_start")->default("18:00");
            $table->string("evening_event_end")->default("21:00");

            $table->integer("price")->default(1000);
        });
    }

    public function down()
    {
        Schema::table('exhibitions', function(Blueprint $table){
            //
        });
    }
}

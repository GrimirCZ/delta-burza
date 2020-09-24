<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IncreaseSizeOfUrls extends Migration
{
    public function up()
    {
        Schema::table('registrations', function(Blueprint $table){
            $table->mediumText("morning_event")->change();
            $table->mediumText("evening_event")->change();
            //
        });
    }

    public function down()
    {
        Schema::table('registrations', function(Blueprint $table){
            //
        });
    }
}

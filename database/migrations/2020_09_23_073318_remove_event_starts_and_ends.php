<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveEventStartsAndEnds extends Migration
{
    public function up()
    {
        Schema::table('registrations', function(Blueprint $table){
            $table->dropColumn("morning_event_start");
            $table->dropColumn("morning_event_end");
            $table->dropColumn("evening_event_start");
            $table->dropColumn("evening_event_end");
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeEventUrlsNullbale extends Migration
{
    public function up()
    {
        Schema::table('registrations', function(Blueprint $table){

            $table->string("morning_event")->nullable()->change();
            $table->string("evening_event")->nullable()->change();
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

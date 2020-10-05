<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExtendColumnNames extends Migration
{
    public function up()
    {
        Schema::table('schools', function(Blueprint $table){
            $table->string("name", 512)->change();
            //
        });
        Schema::table('specializations', function(Blueprint $table){
            $table->string("name", 512)->change();
            //
        });
    }

    public function down()
    {
        Schema::table('specializations', function(Blueprint $table){
            //
        });
    }
}

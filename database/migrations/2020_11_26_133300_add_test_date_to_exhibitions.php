<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTestDateToExhibitions extends Migration
{
    public function up()
    {
        Schema::table('exhibitions', function(Blueprint $table){
            $table->date("test_date")->nullable();
            //
        });
    }

    public function down()
    {
        Schema::table('exhibitions', function(Blueprint $table){
            //
        });
    }
}

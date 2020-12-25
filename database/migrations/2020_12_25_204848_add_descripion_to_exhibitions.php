<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescripionToExhibitions extends Migration
{
    public function up()
    {
        Schema::table('exhibitions', function(Blueprint $table){
            $table->mediumText("description")->nullable();
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

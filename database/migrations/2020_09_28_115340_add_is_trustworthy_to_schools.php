<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsTrustworthyToSchools extends Migration
{
    public function up()
    {
        Schema::table('schools', function(Blueprint $table){
            $table->boolean('is_trustworthy')->default(true);
            //
        });
    }

    public function down()
    {
        Schema::table('schools', function(Blueprint $table){
            //
        });
    }
}

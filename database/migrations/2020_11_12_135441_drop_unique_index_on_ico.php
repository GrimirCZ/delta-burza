<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropUniqueIndexOnIco extends Migration
{
    public function up()
    {
        Schema::table('schools', function(Blueprint $table){
            $table->dropUnique(["ico"]);
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

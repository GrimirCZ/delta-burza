<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForceEnableJoinToExhibitions extends Migration
{
    public function up()
    {
        Schema::table('exhibitions', function(Blueprint $table){
            $table->boolean("force_enable_join")->default(false);
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

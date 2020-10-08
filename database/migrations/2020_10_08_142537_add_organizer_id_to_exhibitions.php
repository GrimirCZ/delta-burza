<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrganizerIdToExhibitions extends Migration
{
    public function up()
    {
        Schema::table('exhibitions', function(Blueprint $table){
            $table->foreignId("organizer_id")->default(1)->constrained();
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

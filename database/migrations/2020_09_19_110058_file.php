<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class File extends Migration
{
    public function up()
    {
        Schema::create('files', function(Blueprint $table){
            $table->bigIncrements('id');

            $table->string("type", 12);
            $table->string("name", 128);
            $table->foreignId("school_id")->constrained();
            //

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('files');
    }
}

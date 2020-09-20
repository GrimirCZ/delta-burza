<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Region extends Migration
{
    public function up()
    {
        Schema::create('regions', function(Blueprint $table){
            $table->bigIncrements('id');

            $table->string("name");
            //

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('regions');
    }
}

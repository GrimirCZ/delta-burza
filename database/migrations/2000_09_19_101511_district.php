<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class District extends Migration
{
    public function up()
    {
        Schema::create('districts', function(Blueprint $table){
            $table->bigIncrements('id');

            $table->string("name");
            $table->foreignId("region_id")->constrained();
            //

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('districts');
    }
}

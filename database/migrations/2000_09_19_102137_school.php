<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class School extends Migration
{
    public function up()
    {
        Schema::create('schools', function(Blueprint $table){
            $table->bigIncrements('id');

            $table->string("address", 255);

            $table->string("ico", 60)->unique();
            $table->string("izo", 60)->unique();

            $table->string("name", 255);

            $table->mediumText("description");

            $table->string("email", 255)->unique();

            $table->string("web")->nullable();
            $table->string("phone")->nullable();

            $table->foreignId("district_id")->constrained();
            //

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('');
    }
}

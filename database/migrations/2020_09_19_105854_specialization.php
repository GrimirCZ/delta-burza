<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Specialization extends Migration
{
    public function up()
    {
        Schema::create('specializations', function(Blueprint $table){
            $table->bigIncrements('id');

            $table->string("name", 45);
            $table->mediumText("description")->nullable();
            $table->foreignId("prescribed_specialization_id")->constrained();
            $table->foreignId("school_id")->constrained();
            //

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('');
    }
}

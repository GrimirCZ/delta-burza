<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PrescribedSpecialization extends Migration
{
    public function up()
    {
        Schema::create('prescribed_specializations', function(Blueprint $table){
            $table->bigIncrements('id');

            $table->string("name");
            $table->string("code");
            $table->foreignId("field_of_study_id")->constrained();
            //

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('avaliable_specializations');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FieldOfStudy extends Migration
{
    public function up()
    {
        Schema::create('field_of_studies', function(Blueprint $table){
            $table->bigIncrements('id');

            $table->string("name");
            $table->foreignId("type_of_study_id")->constrained();
            //

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('');
    }
}

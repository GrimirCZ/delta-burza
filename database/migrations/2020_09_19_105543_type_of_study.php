<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TypeOfStudy extends Migration
{
    public function up()
    {
        Schema::create('type_of_studies', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->string("name");
            $table->string("code");
            //

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('');
    }
}

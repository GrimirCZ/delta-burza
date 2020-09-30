<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCompanySchool extends Migration
{
    public function up()
    {
        Schema::create('company_school', function(Blueprint $table){
            $table->bigIncrements('id');

            $table->foreignId("company_id")->constrained("schools");
            $table->foreignId("school_id")->constrained("schools");
            //

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('company_school');
    }
}

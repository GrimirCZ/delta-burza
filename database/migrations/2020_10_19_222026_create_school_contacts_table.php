<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolContactsTable extends Migration
{
    public function up()
    {
        Schema::create('school_contacts', function(Blueprint $table){
            $table->bigIncrements('id');

            $table->string("name", 255)->nullable();
            $table->string("email", 255)->nullable();
            $table->string("phone", 255)->nullable();
            $table->string("body", 512)->nullable();

            $table->foreignId('school_id')->nullable()->constrained();
            //

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('school_contacts');
    }
}

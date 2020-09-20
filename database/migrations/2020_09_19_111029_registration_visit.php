<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RegistrationVisit extends Migration
{
    public function up()
    {
        Schema::create('registration_visits', function(Blueprint $table){
            $table->bigIncrements('id');

            $table->ipAddress("ip_address");
            $table->string("type");
            $table->foreignId("registration_id")->constrained();
            //

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('registration_visits');
    }
}

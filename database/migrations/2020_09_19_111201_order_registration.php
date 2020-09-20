<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrderRegistration extends Migration
{
    public function up()
    {
        Schema::create('order_registration', function(Blueprint $table){
            $table->bigIncrements('id');

            $table->boolean("is_fulfilled")->default(false);
            $table->integer("price");
            $table->date("fulfilled_at");
            $table->foreignId("order_id")->constrained();
            $table->foreignId("registration_id")->constrained();
            //

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_registration');
    }
}

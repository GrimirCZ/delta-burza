<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Order extends Migration
{
    public function up()
    {
        Schema::create('orders', function(Blueprint $table){
            $table->bigIncrements('id');

            $table->date("due_date");
            $table->foreignId("school_id")->constrained();
            //

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}

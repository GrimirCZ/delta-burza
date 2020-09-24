<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVariabilniCislo extends Migration
{
    public function up()
    {
        Schema::table('orders', function(Blueprint $table){
            $table->string("variable_symbol", 10)->nullable();
            //
        });
    }

    public function down()
    {
        Schema::table('orders', function(Blueprint $table){
            //
        });
    }
}

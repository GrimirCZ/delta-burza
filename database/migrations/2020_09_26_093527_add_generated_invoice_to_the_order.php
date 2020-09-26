<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGeneratedInvoiceToTheOrder extends Migration
{
    public function up()
    {
        Schema::table('orders', function(Blueprint $table){
            $table->string("invoice")->nullable();
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

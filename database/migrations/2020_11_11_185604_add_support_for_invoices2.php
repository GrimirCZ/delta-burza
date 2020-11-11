<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSupportForInvoices2 extends Migration
{
    public function up()
    {
        Schema::table('orders', function(Blueprint $table){
            $table->mediumText("invoice")->nullable();
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeWidthOfInvoiceFieldInOrders extends Migration
{
    public function up()
    {
        Schema::table('orders', function(Blueprint $table){
            $table->mediumText("invoice")->nullable()->change();
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSupportForInvoices extends Migration
{
    public function up()
    {
        Schema::table('orders', function(Blueprint $table){
            $table->dropColumn("variable_symbol");
            $table->renameColumn("invoice", "proforma_invoice");
            $table->integer("invoice_number")->nullable();
            $table->integer("proforma_invoice_number")->nullable();
            $table->integer("invoice_year")->nullable();
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

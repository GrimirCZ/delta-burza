<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyOrderRegistration extends Migration
{
    public function up()
    {
        Schema::table('order_registration', function(Blueprint $table){
            $table->date("fulfilled_at")->nullable()->change();
            //
        });
    }

    public function down()
    {
        Schema::table('order_registration', function(Blueprint $table){
            //
        });
    }
}

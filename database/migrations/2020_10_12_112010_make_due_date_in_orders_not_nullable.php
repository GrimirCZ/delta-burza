<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeDueDateInOrdersNotNullable extends Migration
{
    public function up()
    {
        Schema::table('orders', function(Blueprint $table){
            $table->date("due_date")->nullable(false)->change();
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

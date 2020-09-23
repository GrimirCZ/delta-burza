<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeDueDateNullable extends Migration
{
    public function up()
    {
        Schema::table('order', function(Blueprint $table){
            $table->date("due_date")->nullable()->change();
            //
        });
    }

    public function down()
    {
        Schema::table('order', function(Blueprint $table){
            //
        });
    }
}

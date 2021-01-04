<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeSchoolsEmailNullable extends Migration
{
    public function up()
    {
        Schema::table('schools', function(Blueprint $table){
            $table->string("email", 255)->nullable()->change();
            //
        });
    }

    public function down()
    {
        Schema::table('schools', function(Blueprint $table){
            //
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveIsDisabled extends Migration
{
    public function up()
    {
        Schema::table('registrations', function(Blueprint $table){
            $table->dropColumn('is_disabled');
            //
        });
    }

    public function down()
    {
        Schema::table('registrations', function(Blueprint $table){
            //
        });
    }
}

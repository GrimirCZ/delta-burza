<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeIsDisabledTrueByDefault extends Migration
{
    public function up()
    {
        Schema::table('registrations', function(Blueprint $table){
            $table->boolean("is_disabled")->default(true)->change();

            //
        });
    }

    public function down()
    {
        Schema::dropIfExists('registrations');
    }
}

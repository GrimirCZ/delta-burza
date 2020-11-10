<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalSchoolCountToDistricts extends Migration
{
    public function up()
    {
        Schema::table('districts', function(Blueprint $table){
            $table->integer("total_school_count")->default(0);
            //
        });
    }

    public function down()
    {
        Schema::table('districts', function(Blueprint $table){
            $table->dropColumn("total_school_count");
            //
        });
    }
}

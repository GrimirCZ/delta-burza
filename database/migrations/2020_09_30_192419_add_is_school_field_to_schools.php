<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsSchoolFieldToSchools extends Migration
{
    public function up()
    {
        Schema::table('schools', function(Blueprint $table){
            $table->boolean("is_school")->default(true);
            $table->string("izo", 60)->unique()->nullable()->change();
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

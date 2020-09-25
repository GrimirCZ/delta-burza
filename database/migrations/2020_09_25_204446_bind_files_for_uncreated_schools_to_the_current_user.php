<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BindFilesForUncreatedSchoolsToTheCurrentUser extends Migration
{
    public function up()
    {
        Schema::table('files', function(Blueprint $table){
            DB::affectingStatement("SET FOREIGN_KEY_CHECKS=0;");
            $table->foreignId("school_id")->nullable()->change();
            $table->foreignId("user_id")->nullable()->constrained();
            DB::affectingStatement("SET FOREIGN_KEY_CHECKS=1;");
            //
        });
    }

    public function down()
    {
        Schema::table('files', function(Blueprint $table){
            //
        });
    }
}

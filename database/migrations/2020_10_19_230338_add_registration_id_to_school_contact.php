<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegistrationIdToSchoolContact extends Migration
{
    public function up()
    {
        Schema::table('school_contacts', function(Blueprint $table){
            $table->foreignId("registration_id")->nullable()->constrained();
            //
        });
    }

    public function down()
    {
        Schema::table('school_contact', function(Blueprint $table){
            //
        });
    }
}

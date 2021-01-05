<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspectionReportsTable extends Migration
{
    public function up()
    {
        Schema::create('inspection_reports', function(Blueprint $table){
            $table->bigIncrements('id');

            $table->string("ico");

            $table->date("start_date");
            $table->date("end_date");

            $table->string("url", 255);

            $table->unique(['ico', 'start_date', 'end_date']);

            $table->foreignId("school_id")->constrained();
            //

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inspection_reports');
    }
}

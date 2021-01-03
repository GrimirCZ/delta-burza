<?php

use App\Imports\ImportPSCFromCSV;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;

class CreatePscTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists("psc");

        Schema::create('psc', function(Blueprint $table){
            $table->bigIncrements('id');

            $table->string("psc");
            $table->string("city");
            $table->foreignId("district_id")->constrained();
        });

        Excel::import(new ImportPSCFromCSV, resource_path("data/psc.csv"));
    }

    public function down()
    {
        Schema::dropIfExists('psc');
    }
}

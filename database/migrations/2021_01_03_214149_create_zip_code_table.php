<?php

use App\Imports\ImportZipCodes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;

class CreateZipCodeTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists("zip_codes");

        Schema::create('zip_codes', function(Blueprint $table){
            $table->bigIncrements('id');

            $table->string("zip_code");
            $table->string("city");
            $table->foreignId("district_id")->constrained();
        });

        Excel::import(new ImportZipCodes, resource_path("data/zip_codes.csv"));
    }

    public function down()
    {
        Schema::dropIfExists('zip_codes');
    }
}

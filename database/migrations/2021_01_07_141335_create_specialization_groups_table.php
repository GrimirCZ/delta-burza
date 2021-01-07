<?php

use App\Imports\ImportSpecializationGroups;
use App\Models\SpecializationGroup;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;

class CreateSpecializationGroupsTable extends Migration
{
    public function up()
    {
        Schema::create('specialization_groups', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->string("name");
            $table->string("code");
            //

            $table->timestamps();
        });

        Excel::import(new ImportSpecializationGroups(), resource_path("data/specialization_groups.csv"));
    }

    public function down()
    {
        Schema::dropIfExists('specialization_groups');
    }
}

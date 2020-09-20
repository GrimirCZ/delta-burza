<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NeighboringRegions extends Migration
{
    public function up()
    {
        Schema::create('neighboring_regions', function(Blueprint $table){
            $table->bigIncrements('id');

            $table->foreignId("master_id")->constrained("regions");
            $table->foreignId("neighbor_id")->constrained("regions");
            //

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('neighboring_regions');
    }
}

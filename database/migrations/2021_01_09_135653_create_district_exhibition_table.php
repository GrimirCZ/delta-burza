<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistrictExhibitionTable extends Migration
{
    public function up()
    {
        // maps between exhibition and regions it takes place in, for showing unregistered schools
        Schema::create('district_exhibition', function(Blueprint $table){
            $table->bigIncrements('id');

            $table->foreignId("exhibition_id")->constrained();
            $table->foreignId("district_id")->constrained();
        });

        DB::transaction(function(){
            $exhibitions = \App\Models\Exhibition::all();

            foreach($exhibitions as $ex){
                echo "Migrating $ex->name";

                DB::table("district_exhibition")->insert([
                    'exhibition_id' => $ex->id,
                    'district_id' => $ex->district_id
                ]);
            }
        });
    }

    public function down()
    {
        Schema::dropIfExists('district_exhibition');
    }
}

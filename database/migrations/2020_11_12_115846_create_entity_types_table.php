<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntityTypesTable extends Migration
{
    public function up()
    {
        \Illuminate\Support\Facades\DB::transaction(function(){
            Schema::create('entity_types', function(Blueprint $table){
                $table->bigIncrements('id');

                $table->string("type");

                $table->json("data");
                //

                $table->timestamps();
            });

            DB::table('entity_types')->insert(
                [
                    'type' => 'school',
                    'data' => json_encode([
                        'can_have_related' => false,
                        'can_be_related_to' => true,
                        'has_free_exhibitions' => false,
                        'can_have_specializations' => true,
                        'importance' => 1 // weight of showing
                    ])
                ]
            );

            DB::table('entity_types')->insert(
                [
                    'type' => 'company',
                    'data' => json_encode([
                        'can_have_related' => true,
                        'can_be_related_to' => false,
                        'has_free_exhibitions' => false,
                        'can_have_specializations' => false,
                        'importance' => 10
                    ])
                ]
            );

            DB::table('entity_types')->insert(
                [
                    'type' => 'empl_dep',
                    'data' => json_encode([
                        'can_have_related' => false,
                        'can_be_related_to' => false,
                        'has_free_exhibitions' => true,
                        'can_have_specializations' => false,
                        'importance' => 100
                    ])
                ]
            );
        });
    }

    public
    function down()
    {
        Schema::dropIfExists('entity_types');
    }
}

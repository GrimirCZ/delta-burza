<?php

use App\Models\EntityType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCanShowExamResults extends Migration
{
    public function up()
    {
        Schema::table('entity_types', function(Blueprint $table){
            //

            DB::transaction(function(){
                EntityType::query()->update([
                    'data->can_show_exam_results' => false,
                ]);

                EntityType::query()->where("type", "=", "school")->update([
                    'data->can_show_exam_results' => false,
                ]);
            });
        });
    }

    public function down()
    {
        Schema::table('entity_types', function(Blueprint $table){
            //
        });
    }
}

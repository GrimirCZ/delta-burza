<?php

use App\Models\EntityType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContestTables extends Migration
{
    public function up()
    {
        DB::transaction(function(){
            EntityType::query()->update([
                'data->can_show_contest_results' => false,
            ]);

            EntityType::query()->where("type", "=", "school")->update([
                'data->can_show_contest_results' => true,
            ]);
        });

        DB::unprepared(file_get_contents(resource_path("sql/tmp_tables.sql")));
        DB::unprepared(file_get_contents(resource_path("sql/sql_souteze.sql")));
        DB::unprepared(file_get_contents(resource_path("sql/excelence_points.sql")));
    }

    public function down()
    {
    }
}

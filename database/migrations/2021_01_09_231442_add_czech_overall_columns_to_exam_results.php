<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCzechOverallColumnsToExamResults extends Migration
{
    public function up()
    {
        Schema::table('exam_results', function(Blueprint $table){
            $table->decimal("cze_percentil", 10,5);
            $table->decimal("cze_median", 10,5);
            $table->decimal("cze_uspesnost", 10,5);
            $table->decimal("cze_nepripusteno", 10,5);
            //
        });

        DB::unprepared(file_get_contents(resource_path("sql/cze_standing.sql")));
    }

    public function down()
    {
        Schema::table('exam_results', function(Blueprint $table){
            $table->dropColumn("cze_percentil");
            $table->dropColumn("cze_median");
            $table->dropColumn("cze_uspesnost");
            $table->dropColumn("cze_nepripusteno");
            //
        });
    }
}

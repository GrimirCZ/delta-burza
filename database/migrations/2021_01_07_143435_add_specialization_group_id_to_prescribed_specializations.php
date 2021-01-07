<?php

use App\Imports\LinkPrescribedSpecializationToSpecializationGroupsImport;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;

class AddSpecializationGroupIdToPrescribedSpecializations extends Migration
{
    public function up()
    {
        Schema::table('prescribed_specializations', function(Blueprint $table){
            $table->foreignId("specialization_group_id")->nullable()->constrained();
            //
        });

        Excel::import(new LinkPrescribedSpecializationToSpecializationGroupsImport(), resource_path("data/groups_prescribed_specializations.csv"));
    }

    public function down()
    {
        Schema::table('prescribed_specializations', function(Blueprint $table){
            $table->dropConstrainedForeignId("specialization_group_id");
            $table->dropColumn("specialization_group_id");
            //
        });
    }
}

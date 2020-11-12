<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LinkSchoolsAndEntityTypes extends Migration
{
    public function up()
    {
        DB::transaction(function(){
            $school_type_id = DB::table("entity_types")->where("type", "school")->first("id")->id;
            $company_type_id = DB::table("entity_types")->where("type", "company")->first("id")->id;

            Schema::table('schools', function(Blueprint $table) use ($school_type_id){
                $table->foreignId("entity_type_id")->default($school_type_id)->constrained("entity_types");
                //
            });

            DB::table("schools")->where("is_school", 0)->update([
                'entity_type_id' => $company_type_id
            ]);

            Schema::table('schools', function(Blueprint $table){
                $table->dropColumn("is_school");
                //
            });
        });
    }

    public function down()
    {
        Schema::table('schools', function(Blueprint $table){
            //
        });
    }
}

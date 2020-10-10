<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreationDateAndCoverImageToArticles extends Migration
{
    public function up()
    {
        Schema::table('articles', function(Blueprint $table){
            $table->timestamp("date")->default(DB::raw("CURRENT_TIMESTAMP"));
            $table->string("cover_image")->nullable();
            //
        });
    }

    public function down()
    {
        Schema::table('articles', function(Blueprint $table){
            //
        });
    }
}

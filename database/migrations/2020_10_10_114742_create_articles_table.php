<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    public function up()
    {
        Schema::create('articles', function(Blueprint $table){
            $table->bigIncrements('id');

            $table->string("title", 512);
            $table->mediumText("content");

            $table->boolean("show")->default(false);
            //

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('articles');
    }
}

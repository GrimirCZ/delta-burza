<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    public function up()
    {
        Schema::create('exam_results', function(Blueprint $table){
            $table->bigIncrements('id');

            $table->string("year");
            $table->string("subject");
            $table->string("type");

            $table->integer("podil");
            $table->integer("prihlaseno");
            $table->integer("omluveno");
            $table->integer("vylouceno");
            $table->integer("konalo");
            $table->integer("neuspelo");
            $table->integer("uspelo");

            $table->integer("odlozeny");
            $table->integer("opravny");
            $table->integer("nahradni");

            $table->decimal("percentil",10,3);
            $table->decimal("odchylka",10,3);
            $table->decimal("median",10,3);
            $table->decimal("rozpeti",10,3);
            $table->decimal("percentil25",10,3);
            $table->decimal("percentil75",10,3);

            $table->foreignId("school_id")->constrained();
            $table->foreignId("specialization_group_id")->constrained();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exam_results');
    }
}

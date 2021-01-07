<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    public function up()
    {
        Schema::create('exams', function(Blueprint $table){
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

//            this.year = data.year;
//            this.subject = data.subject;
//
//            this.podil = data["4"];
//            this.prihlaseno = data["5"];
//            this.omluveno = data["6"];
//            this.vylouceno = data["7"];
//            this.konalo = data["8"];
//            this.neuspelo = data["9"];
//            this.uspelo = data["10"];
//            this.percentil = data["11"];
//            this.odchylka = data["12"];
//            this.median = data["13"];
//            this.rozpeti = data["14"];
//            this.percentil25 = data["15"];
//            this.percentil75 = data["16"];
//            this.odlozeny = data["17"];
//            this.opravny = data["18"];
//            this.nahradni = data["19"];
//            this.type = data.type;
//            this.specCode = data.obor[0][2]
//        this.specGroupId = null
//        this.schoolId = null
//        this.redizo = data["1"];
//        this.name = data["2"]
            //

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exams');
    }
}

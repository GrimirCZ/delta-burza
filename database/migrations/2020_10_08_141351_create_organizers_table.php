<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizersTable extends Migration
{
    public function up()
    {
        Schema::create('organizers', function(Blueprint $table){
            $table->bigIncrements('id');

            $table->string("name", 255);
            $table->string("short_name", 255);

            $table->string("address", 255);
            $table->string("city", 255);
            $table->string("psc", 6);
            $table->string("ico", 60)->unique();

            $table->string("email", 255)->nullable()->unique();
            $table->string("phone")->nullable();

            //

            $table->timestamps();
        });

        DB::table('organizers')->insert([
            'name' => "BurzaŠkol.Online",
            'short_name' => "BurzaŠkol.Online",
            'address' => 'Ke Kamenci 151',
            'city' => 'Pardbice',
            'psc' => '530 03',
            'ico' => '62061178',
            'email' => 'info@delta-skola.cz',
            'phone' => '+420 466 611 106'
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('organizers');
    }
}

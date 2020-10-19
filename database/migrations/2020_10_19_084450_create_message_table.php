<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageTable extends Migration
{
    public function up()
    {
        Schema::create('message', function(Blueprint $table){
            $table->bigIncrements('id');

            $table->string("body", 512);
            $table->foreignId("sender_id")->constrained("messengers");
            $table->foreignId("receiver_id")->constrained("messengers");
            //

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('message');
    }
}

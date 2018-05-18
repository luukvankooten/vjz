<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table){
            $table->increments('id');
            $table->integer('hospital_id')->unsigned();
            $table->foreign('hospital_id')
                ->references('id')->on('groups')
                ->onDelete('cascade');
            $table->string('bed', 255);
            $table->string('room', 255);
        });

        Schema::create('consult_room', function (Blueprint $table){
            $table->integer('consult_id')->unsigned();
            $table->integer('room_id')->unsigned();

            $table->foreign('consult_id')
                ->references('id')->on('consults')
                ->onDelete('cascade');

            $table->foreign('room_id')
                ->references('id')->on('rooms')
                ->onDelete('cascade');

            $table->primary(['consult_id', 'room_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consult_room');
        Schema::dropIfExists('rooms');
    }
}

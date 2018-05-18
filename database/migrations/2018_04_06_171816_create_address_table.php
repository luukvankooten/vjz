<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('establishment', 255);
            $table->string('zip', 6);
            $table->string('street', 255);
            $table->integer('number');
            $table->string('addition', 6)->nullable();
            $table->timestamps();
        });

        Schema::create('address_user', function (Blueprint $table){
            $table->integer('address_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->foreign('address_id')
                ->references('id')->on('addresses')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->primary(['address_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('address_user');
        Schema::dropIfExists('addresses');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllergiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allergies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('allergy');
            $table->timestamps();
        });

        Schema::create('allergy_user', function (Blueprint $table) {
            $table->integer('allergy_id')->unsigned();
            $table->foreign('allergy_id')
                ->references('id')
                ->on('allergies')
                ->onDelete('cascade');
            $table->primary(['user_id', 'allergy_id']);

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('allergies');
    }
}

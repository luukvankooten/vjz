<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diseases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('disease');
            $table->string('body_part');
            $table->timestamps();
        });

        Schema::create('medicines', function (Blueprint $table) {
            $table->increments('id');
            $table->string('factory');
            $table->string('medicine');
            $table->timestamps();
        });

        Schema::create('consults', function (Blueprint $table) {
            $table->increments('id');
            $table->mediumText('details');
            $table->timestamps();
        });

        Schema::create('consult_user', function (Blueprint $table){
            $table->increments('id');
            $table->integer('disease_id')->unsigned();
            $table->integer('medicine_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('consult_id')->unsigned();
            $table->integer('practitioner_id')->unsigned();

            $table->foreign('disease_id')
                ->references('id')->on('diseases')
                ->onDelete('cascade');

            $table->foreign('medicine_id')
                ->references('id')->on('medicines')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('consult_id')
                ->references('id')->on('consults')
                ->onDelete('cascade');

            $table->foreign('practitioner_id')
                ->references('id')->on('users')
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
        Schema::dropIfExists('room_consult');
        Schema::dropIfExists('consult_user');
        Schema::dropIfExists('consult');
        Schema::dropIfExists('diseases');
        Schema::dropIfExists('medicines');

    }
}

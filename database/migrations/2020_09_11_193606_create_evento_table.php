<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evento', function (Blueprint $table) {
            $table->Increments('id_evento');

            $table->integer('id_empresa')->unsigned();
            $table->foreign('id_empresa')->references('id')->on('users');
            
            $table->integer('id_persona')->unsigned();
            $table->foreign('id_persona')->references('id')->on('users');

            $table->string('temp');







            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evento');
    }
}

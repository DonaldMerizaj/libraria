<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LibriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('libri', function (Blueprint $table) {
            $table->increments('libri_id');
            $table->string('titulli');
            $table->integer('id_autor')->unsigned();
            $table->string('shtepi_botuese');
            $table->string('viti');
            $table->string('desc');
            $table->integer('cmimi');
            $table->string('image');
            $table->timestamps();
        });

        Schema::table('libri', function (Blueprint $table){
            $table->foreign('id_autor')->references('autor_id')->on('autor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

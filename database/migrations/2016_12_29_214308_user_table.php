<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table){
            $table->increments('user_id');
            $table->string('name');
            $table->string('surname');
            $table->string('email');
            $table->string('cel');
            $table->integer('id_login')->unsigned();
            $table->timestamps();
        });

        Schema::table('user', function (Blueprint $table){
            $table->foreign('id_login')->references('login_id')->on('login');
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

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItriviaRangePointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itrivia__rangepoints', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields
            $table->integer('value')->unsigned()->default(0);
            $table->integer('points')->unsigned()->default(0);

            $table->integer('trivia_id')->unsigned();
            $table->foreign('trivia_id')->references('id')->on('itrivia__trivias')->onDelete('restrict');

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
        Schema::dropIfExists('itrivia__rangepoints');
    }
}

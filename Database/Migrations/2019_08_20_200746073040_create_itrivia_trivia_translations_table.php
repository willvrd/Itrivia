<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItriviaTriviaTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itrivia__trivia_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->string('title');
            $table->text('description')->nullable();

            $table->integer('trivia_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['trivia_id', 'locale']);
            $table->foreign('trivia_id')->references('id')->on('itrivia__trivias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('itrivia__trivia_translations', function (Blueprint $table) {
            $table->dropForeign(['trivia_id']);
        });
        Schema::dropIfExists('itrivia__trivia_translations');
    }
}

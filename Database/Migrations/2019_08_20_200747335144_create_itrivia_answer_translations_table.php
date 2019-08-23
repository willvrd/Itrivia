<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItriviaAnswerTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itrivia__answer_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            // Your translatable fields
            $table->text('title');

            $table->integer('answer_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['answer_id', 'locale']);
            $table->foreign('answer_id')->references('id')->on('itrivia__answers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('itrivia__answer_translations', function (Blueprint $table) {
            $table->dropForeign(['answer_id']);
        });
        Schema::dropIfExists('itrivia__answer_translations');
    }
}

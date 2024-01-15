<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('surveys_questions')) {
            Schema::create('surveys_questions', function (Blueprint $table) {
                $table->id();
                $table->string('question');
                $table->string('tag')->unique()->default(null)->nullable();
                $table->boolean('status')->default(true);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('surveys_answers')) {
            Schema::create('surveys_answers', function (Blueprint $table) {
                $table->id();
                $table->string('answer');
            });
        }

        if (! Schema::hasTable('surveys_question_answer')) {
            Schema::create('surveys_question_answer', function (Blueprint $table) {
                $table->id();
                $table->foreignId('question_id');
                $table->foreignId('answer_id');
                $table->json('votes');

                $table->foreign('question_id')
                    ->references('id')
                    ->on('surveys_questions')
                    ->cascadeOnDelete();

                $table->foreign('answer_id')
                    ->references('id')
                    ->on('surveys_answers')
                    ->cascadeOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surveys_questions');
        Schema::dropIfExists('surveys_answers');
        Schema::dropIfExists('surveys_question_answer');
    }
};

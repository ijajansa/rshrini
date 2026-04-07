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
        if (! Schema::hasTable('student_answer_histories')) {
            Schema::create('student_answer_histories', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('chapter_id')->index();
                $table->integer('question_id')->index();
                $table->string('quiz_id')->nullable()->index();
                $table->longText('question_text')->nullable();
                $table->string('question_image')->nullable();
                $table->string('solution')->nullable();
                $table->longText('solution_text')->nullable();
                $table->string('solution_image')->nullable();
                $table->longText('option1')->nullable();
                $table->string('option1_image')->nullable();
                $table->integer('option1_type')->default(0);
                $table->longText('option2')->nullable();
                $table->string('option2_image')->nullable();
                $table->integer('option2_type')->default(0);
                $table->longText('option3')->nullable();
                $table->string('option3_image')->nullable();
                $table->integer('option3_type')->default(0);
                $table->longText('option4')->nullable();
                $table->string('option4_image')->nullable();
                $table->integer('option4_type')->default(0);
                $table->integer('user_id')->index();
                $table->longText('answer')->nullable();
                $table->integer('is_correct')->default(0);
                $table->integer('attempted')->default(1);
                $table->integer('is_active')->default(1);
                $table->timestamps();
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
        Schema::dropIfExists('student_answer_histories');
    }
};

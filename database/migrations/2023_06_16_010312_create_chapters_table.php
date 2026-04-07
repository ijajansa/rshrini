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
        Schema::create('chapters', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name')->nullable();
            $table->text('pdf')->nullable();
            $table->unsignedBigInteger('subject_id')->index();
            // $table->foreign('subject_id')->references('id')->on('subjects');
            $table->unsignedBigInteger('format_id')->index();
            // $table->foreign('format_id')->references('id')->on('chapter_formats');
            $table->integer('is_active')->default(1);
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
        Schema::dropIfExists('chapters');
    }
};

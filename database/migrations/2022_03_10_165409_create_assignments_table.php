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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id('assignment_id');
            $table->foreignId('course_ref');
            $table->string('title', 100);
            $table->string('description', 255);
            $table->integer('nb_submissions');
            $table->text('test_script')->nullable();
            $table->integer('max_mark');
            $table->integer('course_weight');
            $table->timestamp('start_time')->default(now());
            $table->timestamp('end_time')->nullable()->default(null);
            $table->boolean('is_test')->default(false);
            $table->boolean('can_execute')->default(false);
            $table->integer('submission_size');
            $table->enum('language', ['php', 'javascript', 'python', 'java'])->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('course_ref')->references('course_id')->on('courses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignments');
    }
};

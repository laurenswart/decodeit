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
        Schema::create('enrolments', function (Blueprint $table) {
            $table->id('enrolment_id');
            $table->foreignId('course_ref');
            $table->foreignId('student_ref');
            $table->integer('final_mark')->nullable()->default(null);
            $table->timestamp('marked_at')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('course_ref')
                ->references('course_id')->on('courses')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreign('student_ref')
                ->references('user_id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enrolments');
    }
};

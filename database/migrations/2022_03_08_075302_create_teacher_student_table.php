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
        Schema::create('teacher_student', function (Blueprint $table) {
            $table->foreignId('student_ref');
            $table->foreignId('teacher_ref');
            $table->primary(['student_ref', 'teacher_ref']);

            $table->foreign('student_ref')
                ->references('user_id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreign('teacher_ref')
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
        Schema::dropIfExists('teacher_student');
    }
};

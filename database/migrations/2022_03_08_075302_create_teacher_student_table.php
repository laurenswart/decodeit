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
            $table->foreignId('student_id');
            $table->foreignId('teacher_id');
            $table->primary(['student_id', 'teacher_id']);

            $table->foreign('student_id')
                ->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreign('teacher_id')
                ->references('id')->on('users')
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

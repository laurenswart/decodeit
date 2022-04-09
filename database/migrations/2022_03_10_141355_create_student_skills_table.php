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
        Schema::create('student_skills', function (Blueprint $table) {
            $table->foreignId('enrolment_id');
            $table->foreignId('skill_id');
            $table->primary(['enrolment_id', 'skill_id']);
            $table->integer('mark')->nullable()->default(null);

            $table->foreign('enrolment_id')
                ->references('id')->on('enrolments')
                ->onUpdate('cascade')
                ->onDelete('restrict');
                
            $table->foreign('skill_id')
                ->references('id')->on('skills')
                ->onUpdate('cascade')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_skill');
    }
};

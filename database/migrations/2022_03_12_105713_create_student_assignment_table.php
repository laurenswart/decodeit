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
         Schema::create('student_assignment', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('enrolment_id');
            $table->foreignId('assignment_id');
            $table->boolean('to_mark')->default(false);
            $table->boolean('help_needed')->default(false);
            $table->integer('mark')->nullable()->default(null);
            $table->timestamp('marked_at')->nullable()->default(null);
            

            $table->foreign('assignment_id')
                ->references('id')->on('assignments')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreign('enrolment_id')
                ->references('id')->on('enrolments')
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
        Schema::dropIfExists('student_assignment');
    }
};

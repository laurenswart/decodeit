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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('student_assignment_id');
            $table->enum('status', ['errored', 'ran', 'passed tests'])->nullable(); //todo more statuses ?
            $table->text('feedback')->nullable();
            $table->text('content');
            $table->timestamps();
            

            $table->foreign('student_assignment_id')
                ->references('id')->on('student_assignment')
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
        Schema::dropIfExists('submissions');
    }
};

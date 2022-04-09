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
        Schema::create('assignment_skills', function (Blueprint $table) {
            
            $table->foreignId('assignment_id');
            $table->foreignId('skill_id');
            $table->primary(['assignment_id', 'skill_id']);

            $table->foreign('assignment_id')
                ->references('id')->on('assignments')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('assignment_skills');
    }
};

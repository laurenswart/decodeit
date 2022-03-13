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
            
            $table->foreignId('assignment_ref');
            $table->foreignId('skill_ref');
            $table->primary(['assignment_ref', 'skill_ref']);

            $table->foreign('assignment_ref')
                ->references('assignment_id')->on('assignments')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('skill_ref')
                ->references('skill_id')->on('skills')
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

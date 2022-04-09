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
        Schema::create('assignment_chapter', function (Blueprint $table) {
            $table->foreignId('assignment_id');
            $table->foreignId('chapter_id');
            $table->primary(['assignment_id', 'chapter_id']);

            $table->foreign('assignment_id')
                ->references('id')->on('assignments')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('chapter_id')
                ->references('id')->on('chapters')
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
        Schema::dropIfExists('assignment_chapter_tble');
    }
};

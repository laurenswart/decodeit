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
            $table->foreignId('assignment_ref');
            $table->foreignId('chapter_ref');
            $table->primary(['assignment_ref', 'chapter_ref']);

            $table->foreign('assignment_ref')
                ->references('assignment_id')->on('assignments')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('chapter_ref')
                ->references('chapter_id')->on('chapters')
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

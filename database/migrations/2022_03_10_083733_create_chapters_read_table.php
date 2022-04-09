<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('chapters_read', function (Blueprint $table) {
            $table->foreignId('enrolment_id');
            $table->foreignId('chapter_id');
            $table->primary(['enrolment_id', 'chapter_id']);
            $table->timestamp('read_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('enrolment_id')
                ->references('id')->on('enrolments')
                ->onUpdate('cascade')
                ->onDelete('restrict');
                
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
        Schema::dropIfExists('chapters_read');
    }
};

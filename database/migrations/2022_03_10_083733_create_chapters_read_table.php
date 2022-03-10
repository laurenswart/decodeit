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
            $table->foreignId('enrolment_ref');
            $table->foreignId('chapter_ref');
            $table->primary(['enrolment_ref', 'chapter_ref']);
            $table->timestamp('read_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('enrolment_ref')
                ->references('enrolment_id')->on('enrolments')
                ->onUpdate('cascade')
                ->onDelete('restrict');
                
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
        Schema::dropIfExists('chapters_read');
    }
};

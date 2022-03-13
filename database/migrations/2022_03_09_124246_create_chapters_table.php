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
        Schema::create('chapters', function (Blueprint $table) {
            $table->id('chapter_id');
            $table->foreignId('course_ref');
            $table->string('title', 100);
            $table->text('content')->nullable()->default(null);
            $table->boolean('is_active')->default(true);
            $table->integer('order_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('course_ref')
                ->references('course_id')->on('courses')
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
        Schema::dropIfExists('chapters');
    }
};

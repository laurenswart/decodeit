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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('course_id');
            $table->string('title', 100);
            $table->text('description');
            $table->integer('nb_submissions')->default(1);
            $table->text('test_script')->nullable();
            $table->integer('max_mark')->default(100);
            $table->integer('course_weight')->default(0);
            $table->timestamp('start_time')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('end_time')->nullable()->default(null);
            $table->boolean('is_test')->default(false);
            $table->boolean('can_execute')->default(false);
            $table->integer('submission_size');
            $table->enum('language', ['javascript', 'python', 'xml', 'html', 'css', 'json'])->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('course_id')
                ->references('id')->on('courses')
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
        Schema::dropIfExists('assignments');
    }
};

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
        Schema::create('forum_messages', function (Blueprint $table) {
            $table->id('message_id');
            $table->foreignId('course_ref');
            $table->foreignId('user_ref');
            $table->text('content');
            $table->timestamps();

            $table->foreign('course_ref')->references('course_id')->on('courses');
            $table->foreign('user_ref')->references('user_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forum_messages');
    }
};

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
        Schema::create('plans', function (Blueprint $table) {
            $table->id('plan_id');
            $table->string('title',100);
            $table->string('description', 255);
            $table->integer('nb_courses');
            $table->integer('nb_submissions');
            $table->integer('max_upload_size');
            $table->integer('nb_chapters');
            $table->integer('nb_students');
            $table->integer('nb_assignments');
            $table->decimal('monthly_price', 6, 2);
            $table->decimal('semiyearly_price', 6, 2);
            $table->decimal('yearly_price', 6, 2);
            $table->text('monthly_stripe_id', 255);
            $table->text('semiyearly_stripe_id', 255);
            $table->text('yearly_stripe_id', 255);
            $table->boolean('is_custom');
            $table->boolean('is_active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
};

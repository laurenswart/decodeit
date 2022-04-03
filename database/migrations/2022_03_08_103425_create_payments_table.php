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
        Schema::create('payments', function (Blueprint $table) {
            $table->id('payment_id');
            $table->foreignId('teacher_ref');
            $table->foreignId('plan_ref');
            $table->string('stripe_id');
            $table->decimal('subtotal', 6, 2);
            $table->integer('tax')->default(0);
            $table->decimal('total', 6, 2);
            $table->timestamps();

            $table->foreign('plan_ref')
                ->references('plan_id')->on('plans')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('teacher_ref')
                ->references('user_id')->on('users')
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
        Schema::dropIfExists('payments');
    }
};

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
            $table->id('id');
            $table->foreignId('teacher_ref');

            $table->integer('amount_due');
            $table->integer('amount_paid');
            $table->string('stripe_invoice_id');
            $table->string('country');
            $table->string('reason');
            $table->string('currency');
            $table->string('status');
            $table->string('subscription_ref');
            $table->timestamp('created_at');

            $table->foreign('teacher_ref')
                ->references('id')->on('users')
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

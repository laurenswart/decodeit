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
            $table->foreignId('subscription_ref');
            $table->decimal('amount', 6, 2);
            $table->timestamp('start_date')->default(now());
            $table->timestamp('expires')->nullable()->default(null);
            $table->timestamp('created_at')->default(now());

            $table->foreign('subscription_ref')
                ->references('subscription_id')->on('subscriptions')
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

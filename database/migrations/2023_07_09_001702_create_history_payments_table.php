<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('history_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('payment_id')->comment('foreign key payment');
            $table->bigInteger('tuition_fee')->nullable()->comment('bayaran kuliah');
            $table->bigInteger('total_payment')->nullable()->comment('total pembayaran');
            $table->bigInteger('remain_payment')->nullable()->comment('sisa pembayaran');
            $table->bigInteger('first_payment')->nullable()->comment('pembayaran 1');
            $table->bigInteger('second_payment')->nullable()->comment('pembayaran 2');
            $table->bigInteger('third_payment')->nullable()->comment('pembayaran 3');
            $table->text('description')->nullable()->comment('keterangan');
            $table->string('file')->nullable()->comment('file');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_payments');
    }
};

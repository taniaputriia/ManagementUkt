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
        Schema::create('full_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->comment('foreign key user');
            $table->string('va_number')->comment('nomor VA');
            $table->string('status')->nullable()->comment('status pembayaran');
            $table->text('description')->nullable()->comment('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('full_payments');
    }
};

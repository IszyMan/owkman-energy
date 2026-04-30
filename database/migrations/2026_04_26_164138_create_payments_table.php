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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')->constrained()->onDelete('cascade');

            $table->string('payment_reference')->unique(); 
            // transaction reference from gateway (Paystack, Flutterwave, etc.)

            $table->string('payment_method'); 
            // e.g card, bank_transfer, wallet, cash_on_delivery

            $table->decimal('amount', 10, 2);

            $table->string('currency')->default('NGN');

            $table->string('status')->default('pending');
            // pending, successful, failed, refunded

            $table->timestamp('paid_at')->nullable();

            $table->json('gateway_response')->nullable();
            // stores raw response from payment gateway

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

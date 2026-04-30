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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // User (nullable for guest checkout)
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->onDelete('set null');

            // Unique order number
            $table->string('order_number')->unique();

            // Totals
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);

            // Payment
            $table->string('payment_method'); // e.g. card, transfer
            $table->string('payment_status')->default('pending'); // pending, paid, failed

            // Order status
            $table->string('status')->default('pending'); 
            // pending, processing, shipped, delivered, cancelled

            // Customer info (important for guest checkout)
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');

            // Shipping address
            $table->text('shipping_address');
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('country')->default('Nigeria');
            $table->string('postal_code')->nullable();

            // Notes
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

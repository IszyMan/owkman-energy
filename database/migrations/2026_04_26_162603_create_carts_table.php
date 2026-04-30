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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();

            // For logged-in users
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');

            // For guest users (very important)
            $table->string('session_id')->nullable();

            // Product
            $table->foreignId('product_id')
                ->constrained()
                ->onDelete('cascade');

            // Quantity
            $table->integer('quantity')->default(1);

            // Price snapshot (important for consistency)
            $table->decimal('price', 10, 2);

            // Optional: variations (size, color, etc.)
            $table->string('variant')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};

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
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();

            // Relationship to product
            $table->foreignId('product_id')
                ->constrained()
                ->onDelete('cascade');

            // Image path
            $table->string('image');

            // Optional alt text
            $table->string('alt_text')->nullable();

            // Set primary image
            $table->boolean('is_primary')->default(false);

            // Sorting
            $table->integer('sort_order')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};

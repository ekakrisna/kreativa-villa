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
        Schema::create('product_locations', function (Blueprint $t) {
            $t->id();
            $t->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $t->foreignId('location_id')->constrained('locations')->cascadeOnDelete();
            $t->enum('purpose', ['primary', 'pickup', 'dropoff', 'meeting_point'])->default('primary');
            $t->timestamps();
            $t->unique(['product_id', 'location_id', 'purpose'], 'product_locations_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_locations');
    }
};

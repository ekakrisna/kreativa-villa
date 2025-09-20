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
        Schema::create('product_add_ons', function (Blueprint $t) {
            $t->id();
            $t->foreignId('product_id')->constrained()->cascadeOnDelete();
            $t->foreignId('add_on_id')->constrained('add_ons')->cascadeOnDelete();
            $t->json('overrides')->nullable(); // price/required override
            $t->timestamps();
            $t->unique(['product_id', 'add_on_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_add_ons');
    }
};

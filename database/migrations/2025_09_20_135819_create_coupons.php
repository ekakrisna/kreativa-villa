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
        Schema::create('coupons', function (Blueprint $t) {
            $t->id();
            $t->string('code', 191)->unique();
            $t->enum('type', ['percent', 'amount']);
            $t->decimal('value', 12, 2);
            $t->enum('applies_to', ['product', 'category', 'booking']);
            $t->dateTime('valid_start')->nullable();
            $t->dateTime('valid_end')->nullable();
            $t->integer('usage_limit')->nullable();
            $t->integer('usage_count')->default(0);
            $t->decimal('min_subtotal', 12, 2)->nullable();
            $t->enum('status', ['active', 'inactive'])->default('active');
            $t->json('meta')->nullable();
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};

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
        Schema::create('booking_coupons', function (Blueprint $t) {
            $t->id();
            $t->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $t->foreignId('coupon_id')->constrained()->cascadeOnDelete();
            $t->decimal('discount_amount', 12, 2)->default(0);
            $t->json('meta_snapshot')->nullable();
            $t->timestamps();
            $t->unique(['booking_id', 'coupon_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_coupons');
    }
};

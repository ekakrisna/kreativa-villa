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
        Schema::create('payments', function (Blueprint $t) {
            $t->id();
            $t->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $t->enum('provider', ['xendit', 'stripe', 'cash', 'bank_transfer']);
            $t->enum('method', ['qris', 'va_bca', 'ovo', 'gopay', 'dana', 'card', 'cash', 'manual_transfer'])->nullable();
            $t->decimal('amount', 12, 2)->default(0);
            $t->char('currency', 3)->default('IDR');
            $t->enum('status', [
                'requires_action',
                'accepting_payments',
                'authorized',
                'succeeded',
                'failed',
                'canceled',
                'expired'
            ])->default('accepting_payments');
            $t->string('reference_id', 191)->unique();
            $t->json('raw_response')->nullable();
            $t->timestamp('paid_at')->nullable();
            $t->timestamps();
            $t->index(['booking_id', 'status']);
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

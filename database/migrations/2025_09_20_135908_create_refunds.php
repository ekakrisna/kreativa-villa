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
        Schema::create('refunds', function (Blueprint $t) {
            $t->id();
            $t->foreignId('payment_id')->constrained()->cascadeOnDelete();
            $t->decimal('amount', 12, 2)->default(0);
            $t->string('reason')->nullable();
            $t->enum('status', ['pending', 'succeeded', 'failed'])->default('pending');
            $t->json('raw_response')->nullable();
            $t->timestamp('refunded_at')->nullable();
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refunds');
    }
};

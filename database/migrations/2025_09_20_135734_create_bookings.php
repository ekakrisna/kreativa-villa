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
        Schema::create('bookings', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('code', 191)->unique();
            $t->enum('status', ['draft', 'pending', 'confirmed', 'ongoing', 'completed', 'canceled', 'expired'])->default('pending');
            $t->enum('channel', ['web', 'mobile', 'agent'])->default('web');
            $t->char('currency', 3)->default('IDR');
            $t->decimal('subtotal', 12, 2)->default(0);
            $t->decimal('discount_total', 12, 2)->default(0);
            $t->decimal('tax_total', 12, 2)->default(0);
            $t->decimal('grand_total', 12, 2)->default(0);
            $t->decimal('paid_total', 12, 2)->default(0);
            $t->decimal('due_total', 12, 2)->default(0);
            $t->text('notes')->nullable();
            $t->json('metadata')->nullable();
            $t->timestamps();
            $t->softDeletes();
            $t->index(['user_id', 'status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};

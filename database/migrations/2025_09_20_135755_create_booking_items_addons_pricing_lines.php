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
        Schema::create('booking_items', function (Blueprint $t) {
            $t->id();
            $t->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $t->foreignId('product_id')->constrained()->cascadeOnDelete();
            $t->foreignId('product_unit_id')->nullable()->constrained()->nullOnDelete();
            $t->string('title_snapshot')->nullable();
            $t->json('meta_snapshot')->nullable();
            $t->integer('quantity')->default(1);
            $t->dateTimeTz('start_datetime')->nullable();
            $t->dateTimeTz('end_datetime')->nullable();
            $t->enum('rate_unit', ['per_night', 'per_day', 'per_hour', 'per_package']);
            $t->decimal('base_rate', 12, 2)->default(0);
            $t->decimal('line_subtotal', 12, 2)->default(0);
            $t->decimal('line_discount', 12, 2)->default(0);
            $t->decimal('line_tax', 12, 2)->default(0);
            $t->decimal('line_total', 12, 2)->default(0);
            $t->enum('status', ['pending', 'confirmed', 'canceled', 'refunded'])->default('pending');
            $t->timestamps();
            $t->index(['booking_id', 'product_id', 'start_datetime', 'end_datetime'], 'booking_items_lookup');
        });

        Schema::create('booking_item_add_ons', function (Blueprint $t) {
            $t->id();
            $t->foreignId('booking_item_id')->constrained()->cascadeOnDelete();
            $t->foreignId('add_on_id')->constrained('add_ons')->cascadeOnDelete();
            $t->integer('qty')->default(1);
            $t->decimal('unit_price', 12, 2)->default(0);
            $t->decimal('line_total', 12, 2)->default(0);
            $t->json('meta_snapshot')->nullable();
            $t->timestamps();
            $t->unique(['booking_item_id', 'add_on_id']);
        });

        Schema::create('pricing_lines', function (Blueprint $t) {
            $t->id();
            $t->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $t->foreignId('booking_item_id')->nullable()->constrained()->nullOnDelete();
            $t->enum('code', [
                'base',
                'seasonal_adj',
                'weekend',
                'cleaning_fee',
                'driver',
                'insurance',
                'extra_km',
                'late_return',
                'coupon',
                'tax'
            ]);
            $t->string('description')->nullable();
            $t->decimal('qty', 10, 2)->default(1);
            $t->decimal('unit_price', 12, 2)->default(0);
            $t->decimal('amount', 12, 2)->default(0);
            $t->json('meta')->nullable();
            $t->integer('sort_order')->default(0);
            $t->timestamps();
            $t->index(['booking_id', 'booking_item_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_lines');
        Schema::dropIfExists('booking_item_add_ons');
        Schema::dropIfExists('booking_items');
    }
};

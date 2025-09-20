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
        Schema::create('availability_blocks', function (Blueprint $t) {
            $t->id();
            $t->foreignId('product_id')->constrained()->cascadeOnDelete();
            $t->foreignId('product_unit_id')->nullable()->constrained()->nullOnDelete();
            $t->enum('type', ['available', 'unavailable', 'maintenance', 'owner_block'])->default('unavailable');
            $t->dateTimeTz('start_datetime');
            $t->dateTimeTz('end_datetime');
            $t->string('note')->nullable();
            $t->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $t->timestamps();
            $t->index(['product_id', 'product_unit_id', 'start_datetime', 'end_datetime'], 'availability_lookup');
        });

        Schema::create('seasonal_pricing', function (Blueprint $t) {
            $t->id();
            $t->foreignId('product_id')->constrained()->cascadeOnDelete();
            $t->date('start_date');
            $t->date('end_date');
            $t->decimal('rate', 12, 2);
            $t->enum('rate_unit', ['per_night', 'per_day', 'per_hour', 'per_package']);
            $t->integer('min_nights')->nullable();
            $t->integer('min_days')->nullable();
            $t->tinyInteger('day_of_week_mask')->nullable();
            $t->string('name')->nullable();
            $t->timestamps();
            $t->index(['product_id', 'start_date', 'end_date']);
        });

        Schema::create('dynamic_pricing_rules', function (Blueprint $t) {
            $t->id();
            $t->foreignId('product_id')->constrained()->cascadeOnDelete();
            $t->json('rule');
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dynamic_pricing_rules');
        Schema::dropIfExists('seasonal_pricing');
        Schema::dropIfExists('availability_blocks');
    }
};

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
        Schema::create('products', function (Blueprint $t) {
            $t->id();
            $t->enum('type', ['villa', 'motor', 'car', 'helmet', 'tour']);
            $t->string('title');
            $t->string('slug', 191)->unique();
            $t->longText('description')->nullable();
            $t->char('base_currency', 3)->default('IDR');
            $t->decimal('base_rate', 12, 2)->default(0);
            $t->enum('rate_unit', ['per_night', 'per_day', 'per_hour', 'per_package']);
            $t->integer('capacity')->nullable();
            $t->decimal('deposit_amount', 12, 2)->nullable();
            $t->foreignId('location_id')->nullable()->constrained('locations')->nullOnDelete();
            $t->json('policy')->nullable();
            $t->enum('status', ['draft', 'active', 'inactive'])->default('draft');
            $t->timestamp('published_at')->nullable();
            $t->timestamps();
            $t->softDeletes();
            $t->index(['type', 'status']);
        });

        Schema::create('product_villas', function (Blueprint $t) {
            $t->foreignId('product_id')->primary()->constrained()->cascadeOnDelete();
            $t->integer('bedrooms')->default(1);
            $t->integer('bathrooms')->default(1);
            $t->json('amenities')->nullable();
            $t->time('checkin_time')->nullable();
            $t->time('checkout_time')->nullable();
            $t->decimal('cleaning_fee', 12, 2)->nullable();
        });

        Schema::create('product_vehicles', function (Blueprint $t) {
            $t->foreignId('product_id')->primary()->constrained()->cascadeOnDelete();
            $t->enum('vehicle_type', ['motor', 'car']);
            $t->string('brand')->nullable();
            $t->string('model')->nullable();
            $t->smallInteger('year')->nullable();
            $t->enum('transmission', ['manual', 'automatic'])->nullable();
            $t->enum('fuel_type', ['petrol', 'diesel', 'electric'])->nullable();
            $t->boolean('driver_available')->default(false);
        });

        Schema::create('product_helmets', function (Blueprint $t) {
            $t->foreignId('product_id')->primary()->constrained()->cascadeOnDelete();
            $t->enum('size', ['xs', 's', 'm', 'l', 'xl'])->nullable();
            $t->enum('standard_cert', ['dot', 'snell', 'ece', 'sni'])->nullable();
        });

        Schema::create('product_tours', function (Blueprint $t) {
            $t->foreignId('product_id')->primary()->constrained()->cascadeOnDelete();
            $t->integer('duration_hours')->nullable();
            $t->boolean('is_fixed_departure')->default(false);
            $t->foreignId('default_meeting_point_location_id')->nullable()->constrained('locations')->nullOnDelete();
            $t->json('itinerary')->nullable();
            $t->json('includes')->nullable();
            $t->json('excludes')->nullable();
        });

        Schema::create('product_units', function (Blueprint $t) {
            $t->id();
            $t->foreignId('product_id')->constrained()->cascadeOnDelete();
            $t->string('code', 191);
            $t->string('serial_no')->nullable();
            $t->enum('status', ['available', 'maintenance', 'retired'])->default('available');
            $t->json('metadata')->nullable();
            $t->timestamps();
            $t->softDeletes();
            $t->unique(['product_id', 'code']);
            $t->index(['product_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_units');
        Schema::dropIfExists('product_tours');
        Schema::dropIfExists('product_helmets');
        Schema::dropIfExists('product_vehicles');
        Schema::dropIfExists('product_villas');
        Schema::dropIfExists('products');
    }
};

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
        Schema::create('locations', function (Blueprint $t) {
            $t->id();
            $t->string('label')->nullable();
            $t->string('address_line')->nullable();
            $t->string('city')->nullable();
            $t->string('province')->nullable();
            $t->string('country', 2)->nullable();
            $t->string('postal_code', 20)->nullable();
            $t->decimal('latitude', 10, 7)->nullable();
            $t->decimal('longitude', 10, 7)->nullable();
            $t->enum('type', ['villa_address', 'pickup', 'dropoff', 'meeting_point', 'office'])->nullable();
            $t->json('metadata')->nullable();
            $t->timestamps();
            $t->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};

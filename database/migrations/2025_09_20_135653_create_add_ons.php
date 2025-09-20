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
        Schema::create('add_ons', function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->text('description')->nullable();
            $t->decimal('price', 12, 2)->default(0);
            $t->enum('price_unit', ['per_booking', 'per_day', 'per_hour', 'per_person']);
            $t->boolean('required')->default(false);
            $t->enum('applicable_to', ['villa', 'motor', 'car', 'helmet', 'tour']);
            $t->boolean('is_inventory_tracked')->default(false);
            $t->integer('inventory_qty')->nullable();
            $t->json('metadata')->nullable();
            $t->enum('status', ['active', 'inactive'])->default('active');
            $t->timestamps();
            $t->softDeletes();
            $t->index(['status', 'applicable_to']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('add_ons');
    }
};

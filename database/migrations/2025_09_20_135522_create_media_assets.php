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
        Schema::create('media_assets', function (Blueprint $t) {
            $t->id();
            $t->foreignId('product_id')->constrained()->cascadeOnDelete();
            $t->string('url');
            $t->enum('type', ['image', 'video'])->default('image');
            $t->boolean('is_cover')->default(false);
            $t->integer('sort_order')->default(0);
            $t->json('meta')->nullable();
            $t->timestamps();
            $t->index(['product_id', 'is_cover', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_assets');
    }
};

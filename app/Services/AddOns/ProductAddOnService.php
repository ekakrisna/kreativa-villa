<?php

namespace App\Services\AddOns;

use App\Models\AddOn;
use App\Models\Product;
use App\Models\ProductAddOn;
use App\Services\Contracts\ProductAddOnServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProductAddOnService implements ProductAddOnServiceInterface
{
    public function list(int $productId): array
    {
        return ProductAddOn::with('addOn')
            ->where('product_id', $productId)
            ->orderByDesc('id')
            ->get()
            ->all();
    }

    public function attach(int $productId, array $data): ProductAddOn
    {
        return DB::transaction(function () use ($productId, $data) {
            $product = Product::findOrFail($productId);
            /** @var AddOn $addOn */
            $addOn   = AddOn::findOrFail($data['add_on_id']);

            // Validasi kesesuaian tipe
            if ($addOn->applicable_to !== $product->type) {
                throw ValidationException::withMessages([
                    'add_on_id' => ["Add-on '{$addOn->title}' not applicable to product type '{$product->type}'."],
                ]);
            }

            // Wajib aktif
            if ($addOn->status !== 'active') {
                throw ValidationException::withMessages([
                    'add_on_id' => ['Add-on must be active.'],
                ]);
            }

            // Upsert (unique: product_id + add_on_id)
            $pivot = ProductAddOn::updateOrCreate(
                ['product_id' => $productId, 'add_on_id' => $addOn->id],
                ['overrides'  => $data['overrides'] ?? null]
            );

            return $pivot->fresh(['addOn']);
        });
    }

    public function update(ProductAddOn $pivot, array $data): ProductAddOn
    {
        $pivot->update([
            'overrides' => $data['overrides'] ?? null,
        ]);
        return $pivot->fresh(['addOn']);
    }

    public function detach(ProductAddOn $pivot): void
    {
        $pivot->delete();
    }
}

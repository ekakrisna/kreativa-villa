<?php

namespace App\Services\Products;

use App\Models\ProductUnit;
use App\Services\Contracts\ProductUnitServiceInterface;
use Illuminate\Support\Arr;

class ProductUnitService implements ProductUnitServiceInterface
{
    public function list(int $productId, ?string $status = null): array
    {
        return ProductUnit::query()
            ->where('product_id', $productId)
            ->when($status, fn($x) => $x->where('status', $status))
            ->orderBy('code')
            ->get()
            ->all();
    }

    public function create(int $productId, array $data): ProductUnit
    {
        $data['product_id'] = $productId;
        return ProductUnit::create(Arr::only($data, ['product_id', 'code', 'serial_no', 'status', 'metadata']));
    }

    public function update(ProductUnit $unit, array $data): ProductUnit
    {
        $unit->update(Arr::only($data, ['code', 'serial_no', 'status', 'metadata']));
        return $unit->fresh();
    }

    public function delete(ProductUnit $unit): void
    {
        $unit->delete();
    }
}

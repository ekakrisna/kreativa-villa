<?php

namespace App\Services\Contracts;

use App\Models\ProductUnit;

interface ProductUnitServiceInterface
{
    public function list(int $productId, ?string $status = null): array;
    public function create(int $productId, array $data): ProductUnit;
    public function update(ProductUnit $unit, array $data): ProductUnit;
    public function delete(ProductUnit $unit): void;
}

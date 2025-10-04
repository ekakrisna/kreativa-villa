<?php

namespace App\Services\Contracts;

use App\Models\Product;

interface ProductServiceInterface
{
    public function create(array $data): Product;
    public function update(Product $product, array $data): Product;
    public function delete(Product $product): void;
}

<?php

namespace App\Services\Contracts;

use App\Models\ProductAddOn;

interface ProductAddOnServiceInterface
{
    public function list(int $productId): array;

    /** $data = ['add_on_id'=>int,'overrides'=>[...]] */
    public function attach(int $productId, array $data): ProductAddOn;

    public function update(ProductAddOn $pivot, array $data): ProductAddOn;

    public function detach(ProductAddOn $pivot): void;
}

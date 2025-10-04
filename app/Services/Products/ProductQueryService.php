<?php

namespace App\Services\Products;

use App\Models\Product;
use App\Services\Contracts\ProductQueryServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductQueryService implements ProductQueryServiceInterface
{
    public function adminList(array $filters): LengthAwarePaginator
    {
        $q = Product::query()
            ->when($filters['type'] ?? null, fn($x, $v) => $x->where('type', $v))
            ->when($filters['status'] ?? null, fn($x, $v) => $x->where('status', $v))
            ->when($filters['search'] ?? null, fn($x, $v) => $x->where('title', 'like', "%{$v}%"))
            ->when($filters['categoryId'] ?? null, function ($x, $catId) {
                $x->whereHas('categories', fn($c) => $c->where('categories.id', $catId));
            })
            ->withCount('units')
            ->latest('id');

        return $q->paginate($filters['perPage'] ?? 15);
    }
}

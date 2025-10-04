<?php

namespace App\Services\AddOns;

use App\Models\AddOn;
use App\Services\Contracts\AddOnServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AddOnService implements AddOnServiceInterface
{
    public function paginate(array $filters): LengthAwarePaginator
    {
        $q = AddOn::query()
            ->when($filters['status'] ?? null, fn($x, $v) => $x->where('status', $v))
            ->when($filters['applicable_to'] ?? null, fn($x, $v) => $x->where('applicable_to', $v))
            ->when($filters['search'] ?? null, fn($x, $v) => $x->where('title', 'like', "%{$v}%"))
            ->latest('id');

        return $q->paginate($filters['per_page'] ?? 15);
    }

    public function create(array $data): AddOn
    {
        return AddOn::create($data)->fresh();
    }

    public function update(AddOn $addOn, array $data): AddOn
    {
        $addOn->update($data);
        return $addOn->fresh();
    }

    public function delete(AddOn $addOn): void
    {
        $addOn->delete();
    }
}

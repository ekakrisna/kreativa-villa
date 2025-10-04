<?php

namespace App\Services\Contracts;

use App\Models\AddOn;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AddOnServiceInterface
{
    /** @param array{status?:?string,applicable_to?:?string,search?:?string,per_page?:int} $filters */
    public function paginate(array $filters): LengthAwarePaginator;

    public function create(array $data): AddOn;

    public function update(AddOn $addOn, array $data): AddOn;

    public function delete(AddOn $addOn): void;
}

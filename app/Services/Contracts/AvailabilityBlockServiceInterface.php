<?php

namespace App\Services\Contracts;

use App\Models\AvailabilityBlock;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AvailabilityBlockServiceInterface
{
    /** @param array{product_id?:int,product_unit_id?:int,type?:?string,date_from?:?string,date_to?:?string,per_page?:int} $filters */
    public function paginate(array $filters): LengthAwarePaginator;

    public function create(array $data): AvailabilityBlock;

    public function update(AvailabilityBlock $block, array $data): AvailabilityBlock;

    public function delete(AvailabilityBlock $block): void;
}

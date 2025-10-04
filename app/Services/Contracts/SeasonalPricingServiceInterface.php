<?php

namespace App\Services\Contracts;

use App\Models\SeasonalPricing;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SeasonalPricingServiceInterface
{
    /** @param array{product_id?:int,date_from?:?string,date_to?:?string,per_page?:int} $filters */
    public function paginate(array $filters): LengthAwarePaginator;

    public function create(array $data): SeasonalPricing;

    public function update(SeasonalPricing $season, array $data): SeasonalPricing;

    public function delete(SeasonalPricing $season): void;
}

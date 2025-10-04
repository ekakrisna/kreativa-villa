<?php

namespace App\Services\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProductQueryServiceInterface
{
    /**
     * @param array{type?:?string,status?:?string,search?:?string,categoryId?:?int,perPage?:int} $filters
     */
    public function adminList(array $filters): LengthAwarePaginator;
}

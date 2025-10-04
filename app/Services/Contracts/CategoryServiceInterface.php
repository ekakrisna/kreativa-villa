<?php

namespace App\Services\Contracts;

use App\Models\Category;

interface CategoryServiceInterface
{
    public function list(?int $parentId = null): array;
    public function tree(): array;
    public function create(array $data): Category;
    public function update(Category $category, array $data): Category;
    public function delete(Category $category): void;
}

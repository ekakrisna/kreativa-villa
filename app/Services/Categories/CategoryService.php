<?php

namespace App\Services\Categories;

use App\Models\Category;
use App\Services\Contracts\CategoryServiceInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class CategoryService implements CategoryServiceInterface
{
    public function list(?int $parentId = null): array
    {
        return Category::query()
            ->when(!is_null($parentId), fn($x) => $x->where('parent_id', $parentId))
            ->orderBy('name')
            ->get()
            ->all();
    }

    public function tree(): array
    {
        $all = Category::orderBy('name')->get();
        $byParent = $all->groupBy(fn($c) => $c->parent_id ?? 0);
        $build = function ($pid) use (&$build, $byParent) {
            return ($byParent[$pid] ?? collect())->map(function ($node) use ($build) {
                $node->children = $build($node->id);
                return $node;
            })->values();
        };
        return $build(0)->all();
    }

    public function create(array $data): Category
    {
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }
        return Category::create(Arr::only($data, ['name', 'slug', 'parent_id']));
    }

    public function update(Category $category, array $data): Category
    {
        $category->update(Arr::only($data, ['name', 'slug', 'parent_id']));
        return $category->fresh();
    }

    public function delete(Category $category): void
    {
        // pivot product_categories akan cascade (FK), aman
        $category->delete();
    }
}

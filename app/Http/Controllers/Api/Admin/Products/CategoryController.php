<?php

namespace App\Http\Controllers\Api\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Cateogry\StoreCategoryRequest;
use App\Http\Requests\Api\Admin\Cateogry\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\Contracts\CategoryServiceInterface;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ApiResponse;

    public function __construct(private CategoryServiceInterface $svc) {}

    public function index(Request $request)
    {
        $parentId = $request->input('parent_id');
        $tree     = (bool)$request->input('tree', false);

        $data = $tree
            ? $this->svc->tree()
            : $this->svc->list($parentId);

        return $this->successResponse($data);
    }

    public function store(StoreCategoryRequest $request)
    {
        $cat = $this->svc->create($request->validated());
        return $this->successResponse($cat, 'Category created', 201);
    }

    public function show(Category $category)
    {
        return $this->successResponse($category->loadCount('products'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $cat = $this->svc->update($category, $request->validated());
        return $this->successResponse($cat, 'Category updated');
    }

    public function destroy(Category $category)
    {
        $this->svc->delete($category);
        return $this->successResponse(null, 'Category deleted');
    }
}

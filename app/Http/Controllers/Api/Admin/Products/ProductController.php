<?php

namespace App\Http\Controllers\Api\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Products\StoreProductRequest;
use App\Http\Requests\Api\Admin\Products\UpdateProductRequest;
use App\Models\Product;
use App\Services\Contracts\ProductQueryServiceInterface;
use App\Services\Contracts\ProductServiceInterface;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponse;

    public function __construct(
        private ProductQueryServiceInterface $query,
        private ProductServiceInterface $cmd
    ) {}

    public function index(Request $request)
    {
        $filters = [
            'type'       => $request->string('type')->toString() ?: null,
            'status'     => $request->string('status')->toString() ?: null,
            'search'     => $request->string('search')->toString() ?: null,
            'categoryId' => $request->integer('category_id') ?: null,
            'perPage'    => $request->integer('per_page', 15),
        ];

        $paginator = $this->query->adminList($filters);
        return $this->paginatedResponse($paginator);
    }

    public function store(StoreProductRequest $request)
    {
        $payload = $request->validated();
        $product = $this->cmd->create($payload);
        return $this->successResponse($product, 'Product created', 201);
    }

    public function show(Product $product)
    {
        $product->load([
            'mediaAssets',
            'categories',
            'units',
            'villa',
            'vehicle',
            'helmet',
            'tour',
        ]);

        return $this->successResponse($product);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $updated = $this->cmd->update($product, $request->validated());
        return $this->successResponse($updated, 'Product updated');
    }

    public function destroy(Product $product)
    {
        $this->cmd->delete($product);
        return $this->successResponse(null, 'Product deleted');
    }
}

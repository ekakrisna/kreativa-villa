<?php

namespace App\Http\Controllers\Api\Admin\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Products\StoreProductUnitRequest;
use App\Http\Requests\Api\Admin\Products\UpdateProductUnitRequest;
use App\Models\Product;
use App\Models\ProductUnit;
use App\Services\Contracts\ProductUnitServiceInterface;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ProductUnitController extends Controller
{
    use ApiResponse;

    public function __construct(private ProductUnitServiceInterface $units) {}

    // GET /admin/products/{product}/units
    public function index(Product $product, Request $request)
    {
        $status = $request->string('status')->toString();
        $data = $this->units->list($product->id, $status ?: null);
        return $this->successResponse($data);
    }

    // POST /admin/products/{product}/units
    public function store(Product $product, StoreProductUnitRequest $request)
    {
        $unit = $this->units->create($product->id, $request->validated());
        return $this->successResponse($unit, 'Unit created', 201);
    }

    // PATCH /admin/units/{product_unit}
    public function update(ProductUnit $productUnit, UpdateProductUnitRequest $request)
    {
        $unit = $this->units->update($productUnit, $request->validated());
        return $this->successResponse($unit, 'Unit updated');
    }

    // DELETE /admin/units/{product_unit}
    public function destroy(ProductUnit $productUnit)
    {
        $this->units->delete($productUnit);
        return $this->successResponse(null, 'Unit deleted');
    }
}

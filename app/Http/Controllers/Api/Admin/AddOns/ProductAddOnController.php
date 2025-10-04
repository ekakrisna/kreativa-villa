<?php

namespace App\Http\Controllers\Api\Admin\AddOns;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\AddOns\StoreProductAddOnRequest;
use App\Http\Requests\Api\Admin\AddOns\UpdateProductAddOnRequest;
use App\Models\Product;
use App\Models\ProductAddOn;
use App\Services\Contracts\ProductAddOnServiceInterface;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ProductAddOnController extends Controller
{
    use ApiResponse;

    public function __construct(private ProductAddOnServiceInterface $svc) {}

    // GET /admin/products/{product}/add-ons
    public function index(Product $product)
    {
        $list = $this->svc->list($product->id);
        return $this->successResponse($list);
    }

    // POST /admin/products/{product}/add-ons
    public function store(Product $product, StoreProductAddOnRequest $request)
    {
        $pivot = $this->svc->attach($product->id, $request->validated());
        return $this->successResponse($pivot, 'Add-on attached', 201);
    }

    // PATCH /admin/product-add-ons/{product_add_on}
    public function update(ProductAddOn $product_add_on, UpdateProductAddOnRequest $request)
    {
        $pivot = $this->svc->update($product_add_on, $request->validated());
        return $this->successResponse($pivot, 'Add-on override updated');
    }

    // DELETE /admin/product-add-ons/{product_add_on}
    public function destroy(ProductAddOn $product_add_on)
    {
        $this->svc->detach($product_add_on);
        return $this->successResponse(null, 'Add-on detached');
    }
}

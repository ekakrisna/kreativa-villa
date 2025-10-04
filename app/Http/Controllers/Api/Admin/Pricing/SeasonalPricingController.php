<?php

namespace App\Http\Controllers\Api\Admin\Pricing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Pricing\StoreSeasonalPricingRequest;
use App\Http\Requests\Api\Admin\Pricing\UpdateSeasonalPricingRequest;
use App\Models\SeasonalPricing;
use App\Services\Contracts\SeasonalPricingServiceInterface;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class SeasonalPricingController extends Controller
{
    use ApiResponse;

    public function __construct(private SeasonalPricingServiceInterface $svc) {}

    public function index(Request $request)
    {
        $filters = [
            'product_id' => $request->integer('product_id'),
            'date_from'  => $request->input('date_from'),
            'date_to'    => $request->input('date_to'),
            'per_page'   => $request->integer('per_page', 15),
        ];
        $paginator = $this->svc->paginate($filters);
        return $this->paginatedResponse($paginator);
    }

    public function store(StoreSeasonalPricingRequest $request)
    {
        $model = $this->svc->create($request->validated());
        return $this->successResponse($model, 'Season created', 201);
    }

    public function update(UpdateSeasonalPricingRequest $request, SeasonalPricing $seasonalPricing)
    {
        $model = $this->svc->update($seasonalPricing, $request->validated());
        return $this->successResponse($model, 'Season updated');
    }

    public function destroy(SeasonalPricing $seasonalPricing)
    {
        $this->svc->delete($seasonalPricing);
        return $this->successResponse(null, 'Season deleted');
    }
}

<?php

namespace App\Http\Controllers\Api\Admin\Pricing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Pricing\StoreAvailabilityBlockRequest;
use App\Http\Requests\Api\Admin\Pricing\UpdateAvailabilityBlockRequest;
use App\Models\AvailabilityBlock;
use App\Services\Contracts\AvailabilityBlockServiceInterface;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    use ApiResponse;

    public function __construct(private AvailabilityBlockServiceInterface $svc) {}

    public function index(Request $request)
    {
        $filters = [
            'product_id'      => $request->integer('product_id'),
            'product_unit_id' => $request->integer('product_unit_id'),
            'type'            => $request->input('type'),
            'date_from'       => $request->input('date_from'),
            'date_to'         => $request->input('date_to'),
            'per_page'        => $request->integer('per_page', 15),
        ];
        $paginator = $this->svc->paginate($filters);
        return $this->paginatedResponse($paginator);
    }

    public function store(StoreAvailabilityBlockRequest $request)
    {
        $block = $this->svc->create($request->validated());
        return $this->successResponse($block, 'Availability block created', 201);
    }

    public function update(UpdateAvailabilityBlockRequest $request, AvailabilityBlock $availability)
    {
        $block = $this->svc->update($availability, $request->validated());
        return $this->successResponse($block, 'Availability block updated');
    }

    public function destroy(AvailabilityBlock $availability)
    {
        $this->svc->delete($availability);
        return $this->successResponse(null, 'Availability block deleted');
    }
}

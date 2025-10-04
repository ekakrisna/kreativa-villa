<?php

namespace App\Http\Controllers\Api\Admin\AddOns;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\AddOns\StoreAddOnRequest;
use App\Http\Requests\Api\Admin\AddOns\UpdateAddOnRequest;
use App\Models\AddOn;
use App\Services\Contracts\AddOnServiceInterface;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class AddOnController extends Controller
{
    use ApiResponse;

    public function __construct(private AddOnServiceInterface $svc) {}

    public function index(Request $request)
    {
        $filters = [
            'status'        => $request->input('status'),
            'applicable_to' => $request->input('applicable_to'),
            'search'        => $request->input('search'),
            'per_page'      => $request->integer('per_page', 15),
        ];
        $paginator = $this->svc->paginate($filters);
        return $this->paginatedResponse($paginator);
    }

    public function store(StoreAddOnRequest $request)
    {
        $addOn = $this->svc->create($request->validated());
        return $this->successResponse($addOn, 'Add-on created', 201);
    }

    public function show(AddOn $add_on)
    {
        return $this->successResponse($add_on);
    }

    public function update(UpdateAddOnRequest $request, AddOn $add_on)
    {
        $updated = $this->svc->update($add_on, $request->validated());
        return $this->successResponse($updated, 'Add-on updated');
    }

    public function destroy(AddOn $add_on)
    {
        $this->svc->delete($add_on);
        return $this->successResponse(null, 'Add-on deleted');
    }
}

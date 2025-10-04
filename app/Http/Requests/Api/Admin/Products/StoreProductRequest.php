<?php

namespace App\Http\Requests\Api\Admin\Products;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->role !== 'customer';
    }



    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type'          => 'required|in:villa,motor,car,helmet,tour',
            'title'         => 'required|string|max:191',
            'slug'          => 'nullable|string|max:191|unique:products,slug',
            'description'   => 'nullable|string',
            'base_currency' => 'nullable|string|size:3',
            'base_rate'     => 'required|numeric|min:0',
            'rate_unit'     => 'required|in:per_night,per_day,per_hour,per_package',
            'capacity'      => 'nullable|integer|min:1',
            'deposit_amount' => 'nullable|numeric|min:0',
            'location_id'   => 'nullable|exists:locations,id',
            'policy'        => 'nullable|array',
            'status'        => 'nullable|in:draft,active,inactive',
            'published_at'  => 'nullable|date',

            'categories'    => 'sometimes|array',
            'categories.*'  => 'integer|exists:categories,id',

            'details'       => 'sometimes|array',
        ];
    }
}

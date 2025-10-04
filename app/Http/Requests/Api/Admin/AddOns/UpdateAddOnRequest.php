<?php

namespace App\Http\Requests\Api\Admin\AddOns;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAddOnRequest extends FormRequest
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
            'title'                => ['sometimes', 'string', 'max:191'],
            'description'         => ['nullable', 'string'],
            'price'               => ['sometimes', 'numeric', 'min:0'],
            'price_unit'          => ['sometimes', Rule::in(['per_booking', 'per_day', 'per_hour', 'per_person'])],
            'required'            => ['sometimes', 'boolean'],
            'applicable_to'       => ['sometimes', Rule::in(['villa', 'motor', 'car', 'helmet', 'tour'])],
            'is_inventory_tracked' => ['sometimes', 'boolean'],
            'inventory_qty'       => ['nullable', 'integer', 'min:0'],
            'metadata'            => ['nullable', 'array'],
            'status'              => ['sometimes', Rule::in(['active', 'inactive'])],
        ];
    }
}

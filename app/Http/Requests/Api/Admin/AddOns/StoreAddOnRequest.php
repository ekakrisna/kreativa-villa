<?php

namespace App\Http\Requests\Api\Admin\AddOns;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAddOnRequest extends FormRequest
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
            'title'                => ['required', 'string', 'max:191'],
            'description'         => ['nullable', 'string'],
            'price'               => ['required', 'numeric', 'min:0'],
            'price_unit'          => ['required', Rule::in(['per_booking', 'per_day', 'per_hour', 'per_person'])],
            'required'            => ['boolean'],
            'applicable_to'       => ['required', Rule::in(['villa', 'motor', 'car', 'helmet', 'tour'])],
            'is_inventory_tracked' => ['boolean'],
            'inventory_qty'       => ['nullable', 'integer', 'min:0'],
            'metadata'            => ['nullable', 'array'],
            'status'              => ['required', Rule::in(['active', 'inactive'])],
        ];
    }
}

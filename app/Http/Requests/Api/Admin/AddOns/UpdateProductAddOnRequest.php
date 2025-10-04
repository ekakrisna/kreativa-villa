<?php

namespace App\Http\Requests\Api\Admin\AddOns;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductAddOnRequest extends FormRequest
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
            'overrides'            => ['required', 'array'],
            'overrides.price'      => ['nullable', 'numeric', 'min:0'],
            'overrides.price_unit' => ['nullable', Rule::in(['per_booking', 'per_day', 'per_hour', 'per_person'])],
            'overrides.required'   => ['nullable', 'boolean'],
        ];
    }
}

<?php

namespace App\Http\Requests\Api\Admin\Pricing;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAvailabilityBlockRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->role !== 'customer';;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id'      => ['sometimes', 'integer', 'exists:products,id'],
            'product_unit_id' => ['nullable', 'integer', 'exists:product_units,id'],
            'type'            => ['sometimes', Rule::in(['available', 'unavailable', 'maintenance', 'owner_block'])],
            'start_datetime'  => ['sometimes', 'date'],
            'end_datetime'    => ['sometimes', 'date', 'after:start_datetime'],
            'note'            => ['nullable', 'string', 'max:255'],
        ];
    }
}

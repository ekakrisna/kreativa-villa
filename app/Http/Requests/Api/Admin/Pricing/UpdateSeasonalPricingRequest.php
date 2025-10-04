<?php

namespace App\Http\Requests\Api\Admin\Pricing;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSeasonalPricingRequest extends FormRequest
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
            'start_date' => ['sometimes', 'date'],
            'end_date'   => ['sometimes', 'date', 'after_or_equal:start_date'],
            'rate'       => ['sometimes', 'numeric', 'min:0'],
            'rate_unit'  => ['sometimes', Rule::in(['per_night', 'per_day', 'per_hour', 'per_package'])],
            'min_nights' => ['nullable', 'integer', 'min:1'],
            'min_days'   => ['nullable', 'integer', 'min:1'],
            'days'       => ['nullable', 'array'],
            'days.*'     => ['integer', 'between:1,7'],
            'name'       => ['nullable', 'string', 'max:191'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('days') && is_array($this->input('days'))) {
            $mask = 0;
            foreach ($this->input('days') as $d) {
                $bit = max(1, min(7, (int) $d)) - 1;
                $mask |= (1 << $bit);
            }
            $this->merge(['day_of_week_mask' => $mask]);
        }
    }

    public function validated($key = null, $default = null)
    {
        $data = parent::validated();
        unset($data['days']);
        return $data;
    }
}

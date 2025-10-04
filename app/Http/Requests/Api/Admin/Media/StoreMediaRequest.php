<?php

namespace App\Http\Requests\Api\Admin\Media;

use Illuminate\Foundation\Http\FormRequest;

class StoreMediaRequest extends FormRequest
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
            'product_id' => 'required|exists:products,id',
            'type'       => 'nullable|in:image,video',
            'is_cover'   => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'meta'       => 'nullable|array',
            // salah satu wajib: file atau url
            'file'       => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,mov|max:8192',
            'url'        => 'nullable|url',
        ];
    }

    public function prepareForValidation(): void
    {
        if (!$this->hasFile('file') && !$this->filled('url')) {
            $this->merge(['url' => $this->input('url')]); // biar validator jalan (at least one rule)
        }
    }
}

<?php

namespace App\Http\Requests\Api\Admin\Cateogry;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
        /** @var \App\Models\Category|int|string|null $routeModel */
        $routeModel = $this->route('category');
        $id = $routeModel instanceof Category ? $routeModel->id : (int) $routeModel;

        return [
            'name'      => ['required', 'string', 'max:191'],
            // unique slug, ignore current id
            'slug'      => ['nullable', 'string', 'max:191', "unique:categories,slug,{$id},id"],
            // tidak boleh jadi parent dirinya sendiri
            'parent_id' => ['nullable', 'integer', 'exists:categories,id', 'not_in:' . $id],
        ];
    }

    public function withValidator($validator)
    {
        // (opsional) tambahkan cek sederhana untuk mencegah siklus langsung
        $validator->after(function ($validator) {
            $parentId = (int) $this->input('parent_id');
            $routeModel = $this->route('category');
            $id = $routeModel instanceof Category ? $routeModel->id : (int) $routeModel;

            if ($parentId && $parentId === $id) {
                $validator->errors()->add('parent_id', 'Parent category cannot be itself.');
            }
        });
    }
}

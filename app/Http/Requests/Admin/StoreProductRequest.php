<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only admin can create products
        return auth()->user()->hasRole(['super_admin', 'admin']);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products'],
            'description' => ['nullable', 'string'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'price' => ['required', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0', 'lt:price'],
            'sku' => ['required', 'string', 'max:100', 'unique:products'],
            'stock' => ['required', 'integer', 'min:0'],
            'low_stock_threshold' => ['nullable', 'integer', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'brand_id' => ['required', 'exists:brands,id'],
            'featured' => ['nullable', 'boolean'],
            'best_seller' => ['nullable', 'boolean'],
            'status' => ['required', Rule::in(['draft', 'published', 'archived'])],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:500'],
            'weight' => ['nullable', 'numeric', 'min:0'],
            'dimensions' => ['nullable', 'string', 'max:100'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:2048'],
            'variants' => ['nullable', 'array'],
        ];
    }

    /**
     * Get custom error messages.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Product name is required.',
            'price.required' => 'Price is required.',
            'price.min' => 'Price must be greater than 0.',
            'sku.required' => 'SKU is required.',
            'sku.unique' => 'This SKU already exists.',
            'stock.required' => 'Stock quantity is required.',
            'category_id.required' => 'Please select a category.',
            'brand_id.required' => 'Please select a brand.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Generate slug from name if not provided
        if (!$this->has('slug') && $this->has('name')) {
            $this->merge([
                'slug' => \Illuminate\Support\Str::slug($this->name)
            ]);
        }
    }
}

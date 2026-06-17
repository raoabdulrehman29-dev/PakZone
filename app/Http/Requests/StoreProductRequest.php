<?php

namespace App\Http\Requests\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['requierd','string','max:255'],
            'slug' => ['nullable','string','max:255', 'unique:products'],
            'description' => ['nullable','string'],
            'short_description' => ['nullable','string','max:500'],
            'price' => ['required','numeric','min:0'],
            'sale_price' => ['nullable','numeric','min:0','lt:price'],
            'sku' => ['required','string','unique:products'],
            'stock' => ['required', 'integer','min:0'],
            'low_stock_threshold' => ['nullable','integer','min:0'],
            'category_id' => ['required','exists:categories,id'],
            'brand_id' => ['required','exists:brand,id'],
            'featured' => ['nullable','boolean'],
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
    public function messages()
    {
        return [
            'price..required' => 'the price field in reqiored',
            'sku.required' => 'The sku field in required',
            'category_id.required' => 'please select a specific category',
            'brand_id.required' => 'please select a specific Brand',
        ];
    }
}

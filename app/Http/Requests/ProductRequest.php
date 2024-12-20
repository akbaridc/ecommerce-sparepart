<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Product;

class ProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'min:5'],
            'slug' => ['required', 'string', 'min:5', Rule::unique(Product::class)->ignore(request()->route('product')->id ?? '')],
            'description' => ['required', 'string'],
            'short_description' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:1'],
            'stock' => ['required', 'numeric', 'min:1'],
            'discount' => ['numeric', 'min:0', 'max:100'],
            'image' => [Rule::requiredIf($this->method() === 'POST'), 'image', 'mimes:jpg,jpeg,png,svg,webp,gif', 'max:1028']
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => 'Category field is required.',
            'category_id.exists' => 'Selected category is invalid.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Product;

class StoreProductRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->can('create', Product::class);
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'title' => Str::ucfirst(trim($this->title)),
            'description' => trim($this->description),
            'hashrate_name' => $this->hashrateName,
            'isnew' => $this->has('condition') ? 1 : 0,
            'user_id' => $this->user()->id,
            'country_id' => $this->country,
        ]);
    }

    public function rules()
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'title' => ['required', 'string', 'min:5', 'max:255'],
            'category' => ['required', 'integer', 'exists:categories,id'],
            'description' => ['nullable', 'string', 'max:4096'],
            'price' => ['required', 'integer', 'max:9999999'],
            'quantity' => ['required', 'integer', 'max:9999999'],
            'moq' => ['required', 'integer', 'max:10000'],
            'power' => ['nullable', 'integer', 'max:99999'],
            'hashrate' => ['nullable', 'integer', 'max:9999'],
            'country_id' => ['required', 'integer', 'exists:countries,id'],
            'hashrate_name' => ['required', 'string', Rule::in(array_keys(Product::$hashrates))],
            'isnew' => ['nullable'],
            'image' => ['required', 'file', 'image', 'max:3000', 'dimensions:min_width=500,min_height=300'],
        ];
    }

    public function messages()
{
    return [
        'title.required' => 'Title is required and max:255 symbols',
        'price.required' => 'Price is required',
    ];
}
}

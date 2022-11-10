<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Product;

class UpdateProductRequest extends FormRequest
{

    public function authorize()
    {
        $product = Product::find($this->product->id);
        return $product && $this->user()->can('update', $product);
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'title' => Str::ucfirst(trim($this->title)),
            'description' => trim($this->description),
            'hashrate_name' => $this->hashrateName,
            'isnew' => $this->has('condition') ? 1 : 0,
        ]);
    }

    public function rules()
    {
        return [
            'title' => ['required', 'string', 'min:5', 'max:255'],
            'category' => ['required', 'integer', 'max:5'],
            'description' => ['nullable', 'string', 'max:4096'],
            'price' => ['required', 'integer', 'max:9999999'],
            'quantity' => ['required', 'integer', 'max:9999999'],
            'moq' => ['required', 'integer', 'max:10000'],
            'power' => ['nullable', 'integer', 'max:99999'],
            'hashrate' => ['nullable', 'integer', 'max:9999'],
            'country' => ['required', 'integer', 'exists:countries,id'],
            'hashrate_name' => ['required', 'string', Rule::in(array_keys(Product::$hashrates))],
            'isnew' => ['nullable'],
        ];
    }

}

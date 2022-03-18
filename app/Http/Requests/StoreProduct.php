<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Product;

class StoreProduct extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;

        // $product = Product::find($this->route('product'));
        // return $this->user()->can('update', $product);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required| string| min:5| max:255',
            'category' => 'required| integer| max:5',
            'description' => 'nullable| string| max:4096',
            'price' => 'required| integer| max:9999999',
            'quantity' => 'required| integer| max:9999999',
            'moq' => 'required| integer| max:10000',
            'power' => 'nullable| integer| max:99999',
            'hashrate' => 'nullable| integer| max:9999',
            'country' => 'required| integer',
            'hashrateName' => [
                'required',
                'string',
                Rule::in(array_keys(Product::$hashrates)),
            ],
        ];
    }
}

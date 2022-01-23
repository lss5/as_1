<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
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
            'description' => 'nullable| string| max:4096',
            'price' => 'required| integer',
            'quantity' => 'required| integer',
            'moq' => 'required| integer',
            'country' => 'required| integer',
        ];
    }
}

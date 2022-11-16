<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Product;
use Carbon\Carbon;

class UpdateProductRequest extends FormRequest
{

    public function authorize()
    {
        $product = Product::find($this->product->id);
        return $product && $this->user()->can('update', $product);
    }

    protected function prepareForValidation()
    {
        if (in_array($this->product->status, Product::$status_not_change_edit)) {
            $status = $this->product->status;
        } else {
            $status = Product::$status_default_after_user_edit;
        }

        $this->merge([
            'title' => Str::ucfirst(trim($this->title)),
            'description' => trim($this->description),
            'hashrate_name' => $this->hashrateName,
            'isnew' => $this->has('condition') ? 1 : 0,
            'status' => $status,
            'status_changed_at' => Carbon::now(),
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
            'status' => ['nullable', 'string', Rule::in(Product::$statuses)],
            'status_changed_at' => ['nullable'],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required and max:255 symbols',
            'price.required' => 'Price is required',
            'image.image' => 'The file under validation must be an image (jpeg, png, bmp, gif, svg, or webp)',
            'image.file' => 'The file under validation must be an image (jpeg, png, bmp, gif, svg, or webp)',
            'image.max' => 'The file under validation must be an image (jpeg, png, bmp, gif, svg, or webp)',
            'image.dimensions' => 'The file under validation must be an image (jpeg, png, bmp, gif, svg, or webp)',
        ];
    }
}

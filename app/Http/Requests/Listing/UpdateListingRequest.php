<?php

namespace App\Http\Requests\Listing;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class UpdateListingRequest extends FormRequest
{

    public function authorize()
    {
        return true;

        // $listing = Listing::find($this->listing->id);
        // return $listing && $this->user()->can('update', $listing);
    }

    protected function prepareForValidation()
    {
        // if (in_array($this->listing->status, Listing::$status_not_change_edit)) {
        //     $status = $this->listing->status;
        // } else {
        //     $status = Listing::$status_default_after_user_edit;
        // }

        $this->merge([
            'status_changed_at' => Carbon::now(),

            // 'title' => Str::ucfirst(trim($this->title)),
            'description' => trim($this->description),
            'is_new' => $this->has('condition') ? 1 : 0,
            'user_id' => $this->user()->id,
            'country_id' => $this->country,
            'product_id' => $this->product,
            'status' => 'created',
        ]);
    }

    public function rules()
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'product_id' => ['required', 'exists:products,id'],
            // 'title' => ['required', 'string', 'min:5', 'max:255'],
            // 'category' => ['required', 'integer', 'exists:categories,id'],
            'description' => ['nullable', 'string', 'max:59392'],
            'price' => ['required', 'integer', 'max:9999999'],
            'quantity' => ['required', 'integer', 'max:9999999'],
            'moq' => ['required', 'integer', 'max:10000'],
            'country_id' => ['required', 'integer', 'exists:countries,id'],
            'is_new' => ['nullable'],
            'image' => ['nullable', 'file', 'image', 'max:5000', 'dimensions:min_width=500,min_height=300'],
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

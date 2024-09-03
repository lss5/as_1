<?php

namespace App\Http\Requests\Listing;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Listing;
use Carbon\Carbon;

class UpdateListingRequest extends FormRequest
{

    public function authorize()
    {
        $listing = Listing::find($this->listing->id);
        return $listing && $this->user()->can('update', $listing);
    }

    protected function prepareForValidation()
    {
        if (in_array($this->listing->status, Listing::$status_not_change_edit)) {
            $status = $this->listing->status;
        } else {
            $status = Listing::$status_default_after_user_edit;
        }

        $this->merge([
            'title' => Str::ucfirst(trim($this->title)),
            'description' => trim($this->description),
            'hashrate_name' => Listing::$algorithms[$this->algorithm],
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
            'hashrate_name' => ['required', 'string', Rule::in(array_keys(Listing::$hashrates))],
            'isnew' => ['nullable'],
            'status' => ['nullable', 'string', Rule::in(Listing::$statuses)],
            'status_changed_at' => ['nullable'],
            'algorithm' => ['required', 'string', Rule::in(array_keys(Listing::$algorithms))],
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

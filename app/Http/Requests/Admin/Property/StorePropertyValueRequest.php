<?php

namespace App\Http\Requests\Admin\Property;

use App\Models\Property\Property;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePropertyValueRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'property' => ['required', 'integer', 'exists:properties,id'],
            'value' => ['required', 'string', 'min:1', 'max:255'],
            'sort' => ['nullable', 'integer', 'min:1', 'max:4294967295'],
        ];
    }
}

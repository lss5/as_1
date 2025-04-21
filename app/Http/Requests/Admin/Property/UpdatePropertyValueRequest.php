<?php

namespace App\Http\Requests\Admin\Property;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePropertyValueRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'value' => ['required', 'string', 'min:1', 'max:255'],
            'sort' => ['required', 'integer', 'min:1', 'max:4294967295'],
            'property' => ['required', 'integer', 'exists:properties,id'],
        ];
    }
}

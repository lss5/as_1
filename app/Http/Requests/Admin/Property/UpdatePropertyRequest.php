<?php

namespace App\Http\Requests\Admin\Property;

use App\Models\Property\Property;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePropertyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'unit' => ['required', 'string', 'max:255'],
            'sort' => ['required', 'integer', 'min:1', 'max:4294967295'],
            'value_type' => ['required', Rule::in(Property::VALUE_TYPES)],
            'categories.*' => ['nullable', 'integer', 'exists:categories,id'],
        ];
    }
}

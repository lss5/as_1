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
            'title' => ['required', 'string'],
            'unit' => ['required', 'string'],
            'sort' => ['nullable', 'integer'],
            'value_type' => ['required', Rule::in(Property::VALUE_TYPES)],
            'categories.*' => ['nullable', 'integer', 'exists:categories,id'],
        ];
    }
}

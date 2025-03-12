<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfile extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:10240'],
            'payments' => ['nullable', 'string', 'max:10240'],
            'country' => ['required', 'integer'],
        ];
    }
}

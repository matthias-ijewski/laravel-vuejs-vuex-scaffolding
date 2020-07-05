<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|string|email|max:255'
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Please enter a valid email address.',
            'username.email' => 'Please enter a valid email address.'
        ];
    }
}

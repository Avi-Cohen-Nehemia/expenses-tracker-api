<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserDetailsRequest extends FormRequest
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
            "name" => ["string", "min:3", "max:20"],
            "email" => ["email"],
        ];
    }

    public function messages()
    {
        return [
            "name.min" => "Username must be at least 3 characters long",
            "name.max" => "Username must be less than 20 characters long",
            "email.email" => "Email must be a valid address"
        ];
    }
}

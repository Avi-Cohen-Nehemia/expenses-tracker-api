<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            "name" => ["required", "string", "min:3", "max:20"],
            "email" => ["email"],
            "password" => ["required", "string", "min:8", "max:20"],
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "The Username field is required",
            "name.min" => "Username must be at least 3 characters long",
            "name.max" => "Username must be less than 20 characters long",
            "password.required" => "The Password field is required",
            "password.min" => "Password must be at least 8 characters long",
            "password.max" => "Password must be less than 20 characters long"
        ];
    }
}

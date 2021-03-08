<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
            "amount" => ["required", "numeric", "gt:0"],
            "category" => ["required", "string", "max:30"],
            "type" => ["required", "string", "in:expense,income"],
        ];
    }

    // public function messages()
    // {
    //     return [
    //         'amount.required' => 'Amount is required',
    //         'amount.gt:0' => 'Please enter amount greater than 0',
    //     ];
    // }
}

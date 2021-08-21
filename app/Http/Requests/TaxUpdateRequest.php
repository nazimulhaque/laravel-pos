<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaxUpdateRequest extends FormRequest
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
            'description' => 'required|string|max:255',
            'rate' => 'required|numeric|between:0.01,99.99',
        ];
    }
}

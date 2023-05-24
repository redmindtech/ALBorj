<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
        return
        [
            'name' => 'required|regex: /^[A-Z a-z]+$/',
            'company_name' => 'required',
            'contact_number' => 'required|regex:/^[6-9][0-9]{8}$/',
            'address' => 'required',
            'website'=>'nullable|url'

        ];
    }
    public function messages()
    {
        return
        [
            'name.required' => 'The Client Name is required.',
            'name.regex' => 'The Client Name allows only alphabets.',
            'company_name.required' => 'The Company Name is required.',
            'contact_number.required' => 'The Contact Number is required.',
            'contact_number.regex' => 'Please enter vaild contact number.',
            'address.required' => 'The Address is required.',
            'website.url'=>'Please enter valid url'
        ];
    }
}
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
            'company_name' => 'required|regex: /^[A-Z a-z]+$/',
            'contact_number' => 'required|max:10',
            'address' => 'required',
            'website'=>'required|url'

        ];
    }
    public function messages()
    {
        return
        [
            'name.required' => 'The Client Name is required.',
            'company_name.required' => 'The Contact Name is required.',
            'contact_number.required' => 'The Contact Number is required.',
            'address.required' => 'The Address is required.',
            'website.required'=>'The website is required',
            'website.url'=>'Please enter valid url'
        ];
    }
}
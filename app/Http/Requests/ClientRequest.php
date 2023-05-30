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
            'name' => 'required|regex:/^[A-Z a-z]+$/',
            'company_name' => 'required|regex:/^[a-zA-Z0-9\s]+$/',
            'contact_number' => 'required|numeric|digits:9|regex:/^[5-9][0-9]{8}$/',
            'address' => 'required',
            'website'=>'nullable|url'

        ];
    }
    public function messages()
    {
        return
        [
            'name.required' => 'The Client Name is required.',
            'name.regex' => 'The Client Name allows only alphanumericals',
            'company_name.required' => 'The Company Name is required.',
            'company_name.regex' => 'The Company Name  allows only alphabets',
            'contact_number.required' => 'The Contact Number is required.',
            'contact_number.numeric' => 'The Contact Number allows only Numbers ',
            'contact_number.digits' => 'The Contact Number must be 9 Numbers ',
            'contact_number.regex' => 'The Contact Number must start with 5, 6, 7, 8, or 9.',
            'address.required' => 'The Address is required.',
            'website.url'=>'Please enter valid url'
        ];
    }
}
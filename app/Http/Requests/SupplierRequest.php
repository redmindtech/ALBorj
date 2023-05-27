<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
            'name' => 'required|regex:/^[A-Za-z\s]*$/',
            'company_name' => 'required|regex:/^[A-Za-z\s]*$/',
            'address' => 'required',
            'contact_number' => 'required|numeric|digits:9|regex:/^[5-9][0-9]{8}$/',
            'mail_id' => 'required|email|ends_with:.com',
            'website.url'=>'nullable|url'
        ]; 
    }
    public function messages(){
        return [
            'name.required' => 'The Supplier Name is required.',
            'name.regex'=>'The supplier name allows only alphabets.',
            'company_name.required' => 'The Contact Name is required.',
            'company_name.regex' => 'The Company Name allows only alphabets',
            'address.required' => 'The Address is required.',
            'contact_number.required' => 'The Contact Number is required.',
            'mail_id.required' => 'The Email id is required.',
            'mail_id.email' => 'Please Enter valid email-id.',
            'mail_id.ends_with' => 'Please Enter valid email-id.',
            'website.url'=>'Please enter valid url'
        ];
    }
}

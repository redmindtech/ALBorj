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
            'company_name' => 'required',
            // 'code' => 'required',
            'address' => 'required',
            'contact_number' => 'required|regex:/^[6-9][0-9]{9}$/',
            'mail_id' => 'required|email',
            'website'=>'required|url'
        ]; 
    }
    public function messages(){
        return [
            'name.required' => 'The Supplier Name is required.',
            'name.regex'=>'The supplier name allows only alphabets.',
            'company_name.required' => 'The Contact Name is required.',
            // 'code.required' => 'The Supplier Code is required.',
            'address.required' => 'The Address is required.',
            'contact_number.required' => 'The Contact Number is required.',
             'contact_number.regex'=>'Please enter valid contact number.',
            'mail_id.required' => 'The Email id is required.',
            'mail_id.email' => 'Please Enter valid email-id.',
            
            'website.required'=>'The website is required',
            'website.url'=>'Please enter valid url'
        ];
    }
}

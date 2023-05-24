<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeMasterRequest extends FormRequest
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
            'firstname' => 'required|regex:/^[A-Za-z\s]*$/',
            'lastname' => 'required|regex:/^[A-Za-z\s]*$/',
            'fathername' => 'required|regex:/^[A-Za-z\s]*$/',
            'mothername' => 'required|regex:/^[A-Za-z\s]*$/',
            'join_date' => [
                'required',
            ],
            'end_date' => [
                'nullable',
                'after:join_date'
            ],
            'category' => 'required',
            'sponser' => 'required',
            'working_as' => 'required|regex:/^[A-Za-z\s]*$/',
            'depart' => 'required',
            'desigination' => 'required',
            'status' => 'required',
            'religion' => 'required',
            'nationality' => 'required',
            'city' => 'required',
            'phone' => 'required|regex:/^[6-9][0-9]{9}$/',
            'UAE_mobile_number' => 'required|regex:/^[6-9][0-9]{8}$/',
            'pay_group' => 'required',
            'accomodation' => 'required',
            'passport_expiry_date' => 'required',
            'emirates_id_from_date' => 'required',
            'emirates_id_to_date' => 'required',
            'visa_status' => 'required',
            'expiry_date' => 'required',
            'total_salary' => 'required|numeric',
            'hra' => 'required|numeric',
            'passport_no' => 'required|regex:/^[a-zA-Z0-9]+$/',
            'emirates_id_no' => 'required|regex:/^[0-9]{1,7}$/'



        ];
    }
    public function messages()
    {
        return [

            'firstname.required' => 'The firstname is required.',
            'firstname.regex' => 'The firstname allows only alphabets',
            'lastname.required' => 'The lastname is required.',
            'lastname.regex' => 'The lastname allows only alphabets',
            'fathername.required' => 'The fathername is required.',
            'fathername.regex' => 'The fathername allows only alphabets',
            'mothername.required' => 'The mothername is required.',
            'mothername.regex' => 'The mothername allows only alphabets',
            'join_date.required' => 'The join date is required.',
            'category.required' => 'The category is required',
            'sponser.required' => 'The sponsor is required',
            'working_as.required' => 'The working as is required.',
            'working_as.regex' => 'The working as allows only alphabets',
            'depart.required' => 'The department is required.',
            'desigination.required' => 'The desigination is required.',
            'status.required' => 'The status is required.',
            'religion.required' => 'The religion is required.',
            'nationality.required' => 'The nationality is required.',
            'city.required' => 'The city is required.',
            'phone.required' => 'The phone is required.',
            'phone.regex' => 'The Home Country Contact Number allows only numbers',
            'UAE_mobile_number.required' => 'The UAE mobile number is required.',
            'UAE_mobile_number.regex' => 'Please enter valid number',
            'pay_group.required' => 'The pay group is required.',
            'accomodation.required' => 'The accomodation is required.',
            'passport_expiry_date.required' => 'The passport expiry date is required.',
            'emirates_id_from_date.required' => 'The emirates id from date is required.',
            'emirates_id_to_date.required' => 'The emirates id to date is required.',
            'visa_status.required' => 'The visa status is required.',
            'expiry_date.required' => 'The visa end date is required.',
            'total_salary.required' => 'The total salary is required.',
            'total_salary.numeric' => 'The total salary allows only numbers.',
            'hra.required' => 'The HRA is required.',
            'hra.numeric' => 'The HRA allows only numbers.',
            'passport_no.required' => 'The passport no is required.',
            'passport_no.regex' => 'The passport no does not allow special characters.',
            'emirates_id_no.required' => 'The emirates id no is required.',
            'emirates_id_no.regex' => 'The emirates id no allow only numbers up to 7 digits.'


        ];
    }

}
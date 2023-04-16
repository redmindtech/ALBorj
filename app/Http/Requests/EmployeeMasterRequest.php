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
            'firstname' => 'required',
            'lastname' => 'required',
            'fathername' => 'required',
            'mothername' => 'required',
            'join_date' => 'required',
            'end_date' => 'required',
            'category' => 'required',
            'sponser' => 'required',
            'working_as' => 'required',
            'desigination' => 'required',
            'depart' => 'required',
            'status' => 'required',
            'religion' => 'required',
            'nationality' => 'required',
            'city' => 'required',
            'phone' => 'required|numeric',
            'UAE_mobile_number' => 'required|numeric',
            'pay_group' => 'required',
            'accomodation' => 'required',
            'passport_no' => 'required',
            'passport_expiry_date' => '',
            'emirates_id_no' => 'required',
            'emirates_id_from_date' => 'required',
            'emirates_id_to_date' => 'required',
            'visa_status'=>'required',
            'expiry_date'=>'required',
            'total_salary'=>'required',
            'hra'=>'required',

        ];
    }
    public function messages(){
        return [

            'firstname.required' => 'The firstname is required.',
            'lastname.required' => 'The lastname is required.',
            'fathername.required' => 'The fathername is required.',
            'mothername.required' => 'The mothername is required.',
            'join_date.required' => 'The join_date is required.',
            'category.required'=>'The category is required',
            'sponser.required'=>'The sponser is required',
            'working_as.required' => 'The working_as is required.',
            'desigination.required' => 'The desigination is required.',
            'depart.required' => 'The depart is required.',
            'status.required' => 'The status is required.',
            'religion.required' => 'The religion is required.',
            'nationality.required' => 'The nationality is required.',
            'city.required' => 'The city is required.',
            'phone.required' => 'The phone is required.',
            'UAE_mobile_number.required' => 'The UAE_mobile_number is required.',
            'pay_group.required' => 'The pay_group is required.',
            'accomodation.required' => 'The accomodation is required.',
            'passport_no.required' => 'The passport_no is required.',
            'passport_expiry_date.required' => 'The passport_expiry_date is required.',
            'emirates_id_no.required' => 'The emirates_id_no is required.',
            'emirates_id_from_date.required' => 'The emirates_id_from_date is required.',
            'visa_status.required' => 'The visa_status is required.',
            'expiry_date.required' => 'The expiry_date is required.',
            'total_salary.required' => 'The total_salary is required.',
        ];
    }

}

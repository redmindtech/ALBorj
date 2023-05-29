<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiteRequest extends FormRequest
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
                'site_name' => 'required|alpha_num',
                'site_location' => 'required|regex:/^[A-Z a-z]+$/',
                'site_building' => 'required|alpha_num',
                'site_floor' => 'required|alpha_num',
                'room_number' => 'required|alpha_num',
                'site_address' => 'required',
                'site_status'=>'required',
                // 'firstname'=>'required|regex:/^[A-Z a-z]+$/',
                'firstname' =>
                [  
                    function ($attribute, $value, $fail) 
                    {
                        $employeeNo = $this->input('site_manager');
                        if (empty($employeeNo) && $employeeNo !== $value) 
                        {
                            $fail('Please Enter Valid SiteManager Name.');
                        }
                    },
                        'required',
                        'regex:/^[A-Za-z\s]+$/',
                  
                ],
        ]; 
    }
    public function messages(){
        return [
                'site_name.required' => 'The Site Name is required.',
                'site_name.alpha_num' => 'Please enter numerical values for the Site Name',
                'site_location.required' => 'The Site Location is required.',
                'site_location.regex' => 'The Site Location allows only alphabets.',
                'site_building.required' => 'The Site Building is required.',
                'site_building.alpha_num' => 'Please enter numerical values for the Site Building',
                'site_floor.required' => 'The site Floor is required.',
                'site_floor.alpha_num' => 'Please enter numerical values for the Site Floor',
                'room_number.required' => 'The Room Number is required.',
                'room_number.alpha_num' => 'Please enter numerical values for the Room Number',
                'site_address.required' => 'The Site Address is required.',
                'site_status.required'=>'The Site Status is required',
                'firstname.required'=>'The Site Manager is required',
                'firstname.regex'=>'The Site Manager allows only alphabets'
        ];
    }
}

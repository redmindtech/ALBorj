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
            'site_name' => 'required',
            'site_location' => 'required',
            'site_building' => 'required',
            'site_floor' => 'required',
            'room_number' => 'required',
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
            'site_location.required' => 'The Site Location is required.',
            'site_building.required' => 'The Site Building is required.',
            'site_floor.required' => 'The Site Floor is required.',
            'room_number.required' => 'The Room Number is required.',
            'site_address.required' => 'The Site Address is required.',
            'site_status.required'=>'The Site Status is required',
            'firstname.required'=>'The Site Manager is required',
            'firstname.regex'=>'The Site Manager allows only alphabets'
        ];
    }
}

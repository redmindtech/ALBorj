<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectMasterRequest extends FormRequest
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
                // 'site_name' => 'required|regex:/^[A-Z a-z]+$/',
                'project_name' => 'required|regex:/^[A-Z a-z]+$/',
                'project_type' => 'required',
                // 'firstname' => 'required|regex:/^[A-Z a-z]+$/',
                // 'company_name' => 'required|regex:/^[A-Z a-z]+$/',
                'consultant_name' =>'nullable|regex:/^[A-Za-z\s]*$/',           
                'start_date'=>'required',
                'end_date'=>[ 'required','after:start_date'],
                'actual_project_end_date'=>[ 'required','after:start_date'],
                'status'=>'required',
                'total_price_cost'=>'required|numeric',
                'advanced_amount'=>'required|numeric',
                'retention'=>'nullable|numeric',
                'amount_to_be_received'=>'required|numeric',
                'amount_return'=>'nullable|numeric',
                'firstname' =>
                [  
                    function ($attribute, $value, $fail) 
                    {
                        $employeeNo = $this->input('employee_no');
                        if (empty($employeeNo) && $employeeNo !== $value) 
                        {
                            $fail('Please enter a valid Manager Name.');
                        }
                    },
                        'required',
                        'regex:/^[A-Za-z\s]+$/',
                  
                ],
                'site_name' =>
                [  
                    'required',
                    'regex:/^[a-zA-Z0-9\s]+$/',
                    function ($attribute, $value, $fail) 
                    {
                        $siteNo = $this->input('site_no');
                        if (empty($siteNo) && $siteNo !== $value) 
                        {
                            $fail('Please enter a valid Site Name.');
                        }
                    },
                  
                ],
                'company_name' => 
                [  
                    function ($attribute, $value, $fail) 
                    {
                        $clientNo = $this->input('client_no');
                        if (empty($clientNo) && $clientNo !== $value) 
                        {
                            $fail('Please enter a valid Client / Company Name.');
                        }
                    },
                        'required',
                        'regex:/^[a-zA-Z0-9\s]+$/',
                  
                ],
            ]; 
    }
    public function messages(){
        return [
                'site_name.required' => 'The Site Name is required.',
                'site_name.regex' => 'The Site Name allows only alpha numerical',
                'project_name.required' => 'The Project Name is required.',
                'project_name.regex' => 'The Project Name allows only alphabets',
                'project_type.required' => 'The Project Type is required.',
                'firstname.required' => 'The Manager Name is required.',
                'firstname.regex' => 'The Manager allows only alphabets',
                'company_name.required' => 'The Client / Company Name is required.',
                'company_name.regex' => 'The Client / Company allows only alphanumerical',
                'consultant_name.regex:/^[A-Za-z\s]*$/' => 'The Consultant name allows only alphabets',            
                'start_date.required'=>'The Project Start Date is required',
                'end_date.required'=>'Tentative Project End Date is required',
                'end_date.after'=>'Tentative Project End Date  must be a date after start date.',
                'actual_project_end_date.required'=>'The Actual Project End Date is required',
                'status.required'=>'The Project Status is required',
                'total_price_cost.required'=>'The Total Project Cost is required',
                'total_price_cost.numeric'=>'The Total Project Cost allows only numbers',
                'advanced_amount.required'=>'The Advance Amount is required',
                'advanced_amount.numeric'=>'The Advance Amount is allow only numbers',            
                'retention.numeric'=>'The Retention allows only numbers',
                'amount_to_be_received.required'=>'The Balance Amount To Be Received is required',
                'amount_to_be_received.numeric'=>'The Balance Amount To Be Received allows only numbers',            
                'amount_return.numeric'=>'The Amount Return allows only numbers'

            ];
    }
}

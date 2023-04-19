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
             'site_name' => 'required',
             'project_name' => 'required',
              'project_type' => 'required',
             'firstname' => 'required',
             'company_name' => 'required',
             'consultant_name' =>'nullable|regex:/^[A-Za-z\s]*$/',           
             'start_date'=>'required',
             'end_date'=>'required',
             'actual_project_end_date'=>'required',
             'status'=>'required',
             'total_price_cost'=>'required|numeric',
             'advanced_amount'=>'required|numeric',
            'retention'=>'nullable|numeric',
            'amount_to_be_received'=>'required|numeric',
            'amount_return'=>'nullable|numeric'


        ]; 
    }
    public function messages(){
        return [
            'site_name.required' => 'The Site Name is required.',
            'project_name.required' => 'The Project Name is required.',
              'project_type.required' => 'The Project Type is required.',
             'firstname.required' => 'The Manager Name is required.',
             'company_name.required' => 'The Client / Company Name is required.',
             'consultant_name.regex:/^[A-Za-z\s]*$/' => 'Please enter valid consultant_name.',            
             'start_date.required'=>'The Project Start Date is required',
             'end_date.required'=>'The Tentative Project End Date is required',
            'actual_project_end_date.required'=>'The Actual Project End Date is required',
             'status.required'=>'The Project Status is required',
             'total_price_cost.required'=>'The Total Project Cost is required',
             'total_price_cost.numeric'=>'The Total Project Cost is allow only numbers',
            'advanced_amount.required'=>'The Advance Amount is required',
            'advanced_amount.numeric'=>'The Advance Amount is allow only numbers',            
            'retention.numeric'=>'The Advance Amount is allow only numbers',
            'amount_to_be_received.required'=>'The Balance Amount To Be Received is required',
            'amount_to_be_received.numeric'=>'The Balance Amount To Be Received is allow only numbers',            
            'amount_return.numeric'=>'The Amount Return is allow only numbers'

        ];
    }
}

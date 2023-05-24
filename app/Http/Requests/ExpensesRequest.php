<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpensesRequest extends FormRequest
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
        
            'employee_no' => 'required',
            'project_no' => 'required',
            'exp_category_no'=>'required',
            'supplier_no'=>'required',
            'bill_amount'=>'required',
            'source'=>'required',
            'vat'=>'required',
            // 'total_amount'=>'required',
            'name'=>'required',


        ];
    }

    public function messages()
    {
        return [

            'employee_no.required' => 'The Employee Name is required.',
            'project_no.required' => 'The Project Name is required.',
            'name.required' => 'The Supplier Name is required.',
            'exp_category_no.required' => 'The Expenses Category is required.',
            'supplier_no.required' => 'The Supplier Name is required.',
            'bill_amount.required' => 'The Bill Amount is required.',
            'source.required' => 'The Source is required.',
            'vat.required' => 'The Vat is required.',
            'total_amount.required' => 'The Total Amount is required.',

        ];
    }

}

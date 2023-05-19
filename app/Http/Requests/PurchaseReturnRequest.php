<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseReturnRequest extends FormRequest
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
            'supplier_no' => 'required',
            'pr_purchase_type' => 'required',
             'project_no' => 'required',
           
        ]; 
    }
    public function messages(){
        return [
            'supplier_no.required' => 'The Supplier Name is required.',
            
             'pr_purchase_type.required' => 'The Purchase type is required.',
            'project_no.required' => 'The Project Name is required.',
           
        ];
    }
}

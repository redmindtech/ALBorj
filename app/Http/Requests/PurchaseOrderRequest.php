<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseOrderRequest extends FormRequest
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
            'po_type' => 'required',
            'supplier_no' => 'required',
            'po_date' => 'required',
            'quote_date'=>'required',
            'currency'=>'required',
            'credit_period'=>'required',
            'payment_terms'=>'required',
            'delivery_location'=>'required',
            'delivery_terms'=>'required',
            'total_amount'=>'required',
            'gross_amount'=>'required',
            'po_prepared'=>'required',
            

    ];
 }
 public function messages(){
    return [
        'po_type.required' => 'The Purchase Type is required.',
        'supplier_no.required' => 'The Supplier Name is required.',
        'po_date.required' => 'The  Date is required.',
        'quote_date.required'=>'The Quote Date is required',
        'currency.required'=>'The Currency is required',
        'credit_period.required'=>'The Credit Period is required',
        'payment_terms.required'=>'The Payment Terms is required',
        'delivery_location.required'=>'The Delivery Location is required',
        'delivery_terms.required'=>'The Delivery Terms is required',
        'total_amount.required'=>'The Total Amount is required',
        'gross_amount.required'=>'The Gross Amount is required',
        'po_prepared.required'=>'The Prepared By is required',



 ];
}
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
            'item_name' => 'required|alpha_num',
            'item_category' => 'required',
            'item_subcategory' => 'required',
            'stock_type' => 'required',
            'item_type' => 'required',
            'item_qty'=>'nullable|regex:/^[0-9]*$/',           
            'total_quantity'=>'nullable|regex:/^[0-9]*$/',

        ];
    }
    public function messages(){
        return [
            'item_name.required' => 'The Item Name is required.',  
            'item_name.alpha_num' => 'Please enter numerical values for the Item Name',     
            'item_category.required' => 'The Item Category is required.',
            'item_subcategory.required' => 'The Item SubCategory is required.',
            'stock_type.required' => 'The Stock Type is required.',
            'item_type.required' => 'The Item Type is required.',           
            'item_qty.regex' => 'The Item Quantity allows only numbers not decimal numbers.',             
            'total_quantity.regex' => 'The Item Quantity allows only numbers not decimal numbers.',            




        ];
    }
}
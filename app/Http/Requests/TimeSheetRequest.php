<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TimeSheetRequest extends FormRequest
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
            'project_name' => 'required',
            'site_name' => 'required',
            'from_date' => 'required|date',
            'to_date' => [ 'required','after:from_date'],
        ];
    }
    public function messages()
    {
        return [

            'firstname.required' => 'The Employee Name is required.',
            'firstname.regex' => 'The Employee Name allows only alphabets',
            'project_name.required' => 'The Project Name is required.',
            'site_name.required' => 'The Site Name is required.',
            'from_date.required' => 'The from date field is required',
            'to_date.required' => 'The to date field is required',
            'from_date.date' => 'The from date must be a valid date',
            'to_date.date' => 'The to date must be a valid date',
            'to_date.after_or_equal' => 'The to date must be greater than or equal to the from date'      
        ];
    }

}

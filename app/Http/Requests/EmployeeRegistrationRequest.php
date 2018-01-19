<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeRegistrationRequest extends FormRequest
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
            'name'              =>  [
                                        'required',
                                        'max:200',
                                    ],
            'phone'             =>  [
                                        'required',
                                        'numeric',
                                        'digits_between:10,13',
                                        'unique:account_details',
                                    ],
            'address'           =>  [
                                        'nullable',
                                        'max:200',
                                    ],
            'image_file'        =>  [
                                        'nullable',
                                        'mimes:jpeg,jpg,bmp,png',
                                        'max:3000',
                                    ],
            'wage_type'         =>  [
                                        'required',
                                        'max:7',
                                        Rule::in(['staff','labour']),
                                    ],
            'wage'              =>  [
                                        'required',
                                        'numeric',
                                    ],
            'account_name'      =>  [
                                        'required',
                                        'max:200',
                                        'unique:accounts',
                                    ],
            'financial_status'  =>  [
                                        'required',
                                        Rule::in([0, 1, 2])
                                    ],
            'opening_balance'   =>  [
                                        'required',
                                        'numeric',
                                        'max:9999999'
                                    ]
        ];
    }
}
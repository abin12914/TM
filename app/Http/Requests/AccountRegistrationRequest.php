<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccountRegistrationRequest extends FormRequest
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
            'account_name'          =>  [
                                            'required',
                                            'max:200',
                                            'unique:accounts',
                                        ],
            'description'           =>  [
                                            'nullable',
                                            'max:200',
                                        ],
            /*'account_type'          =>  [
                                            'required',
                                            'max:8',
                                            Rule::in([1, 2, 3])
                                        ],*/
            'financial_status'      =>  [
                                            'required',
                                            'max:8',
                                            Rule::in([0, 1, 2])
                                        ],
            'opening_balance'       =>  [
                                            'required'
                                            'numeric',
                                            'max:9999999',
                                        ],
            'name'                  =>  [
                                            'required',
                                            'max:200',
                                        ],
            'phone'                 =>  [
                                            'required',
                                            'numeric',
                                            'digits_between:10,13',
                                            Rule::unique('account_details')->ignore($this->account_id),
                                        ],
            'address'               =>  [
                                            'nullable',
                                            'max:200',
                                        ],
            'relation_type'         =>  [
                                            'required',
                                            Rule::in([1, 2, 3, 4])
                                        ],
        ];
    }
}

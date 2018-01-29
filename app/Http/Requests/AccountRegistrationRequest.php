<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Repositories\AccountRepository;

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
        $relationTypes  = (new AccountRepository())->relationTypes;

        return [
            'account_name'          =>  [
                                            'required',
                                            'max:200',
                                            Rule::unique('accounts')->ignore($this->id),
                                        ],
            'description'           =>  [
                                            'nullable',
                                            'max:200',
                                        ],
            'financial_status'      =>  [
                                            'required',
                                            Rule::in([0, 1, 2]),
                                        ],
            'opening_balance'       =>  [
                                            'required',
                                            'numeric',
                                            'min:0',
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
                                            Rule::unique('account_details')->ignore($this->id),
                                        ],
            'address'               =>  [
                                            'nullable',
                                            'max:200',
                                        ],
            'image_file'            =>  [
                                            'nullable',
                                            'mimetypes:image/jpeg,image/jpg,image/bmp,image/png',
                                            'max:3000',
                                        ],
            'relation_type'         =>  [
                                            'required',
                                            Rule::in(array_keys($relationTypes)),
                                        ],
        ];
    }
}

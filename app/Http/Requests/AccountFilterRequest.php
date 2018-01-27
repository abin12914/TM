<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Account;
use App\Repositories\AccountRepository;

class AccountFilterRequest extends FormRequest
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
            'account_id'    =>  [
                                    'nullable',
                                    Rule::in(Account::pluck('id')->toArray()),
                                ],
            'relation_type' =>  [
                                    'nullable',
                                    Rule::in(array_keys($relationTypes)),
                                ],
            'page'          =>  [
                                    'nullable',
                                    'integer',
                                ],
            'no_of_records' =>  [
                                    'nullable',
                                    'integer',
                                ],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Account;

class VoucherFilterRequest extends FormRequest
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
            'from_date'                 =>  [
                                                'nullable',
                                                'date_format:d-m-Y',
                                            ],
            'to_date'                   =>  [
                                                'nullable',
                                                'date_format:d-m-Y',
                                            ],
            'account_id'                =>  [
                                                'nullable',
                                                Rule::in(Account::pluck('id')->toArray()),
                                            ],
            'transaction_type_debit'    =>  [
                                                'nullable',
                                                Rule::in([1]),
                                            ],
            'transaction_type_credit'   =>  [
                                                'nullable',
                                                Rule::in([2]),
                                            ],
            'page'                      =>  [
                                                'nullable',
                                                'integer',
                                            ],
            'no_of_records'             =>  [
                                                'nullable',
                                                'min:2',
                                                'integer',
                                            ],
        ];
    }
}

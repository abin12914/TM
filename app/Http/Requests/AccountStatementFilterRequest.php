<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Account;
use App\Repositories\ReportRepository;

class AccountStatementFilterRequest extends FormRequest
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
        $transactionRelations  = (new ReportRepository())->transactionRelations;

        return [
            'from_date'         =>  [
                                        'nullable',
                                        'date_format:d-m-Y',
                                    ],
            'to_date'           =>  [
                                        'nullable',
                                        'date_format:d-m-Y',
                                    ],
            'account_id'        =>  [
                                        'nullable',
                                        Rule::in(Account::pluck('id')->toArray()),
                                    ],
            'relation_type'     =>  [
                                        'nullable',
                                        Rule::in(array_keys($transactionRelations)),
                                    ],
            'transaction_type'  =>  [
                                        'nullable',
                                        Rule::in([1,2]),
                                    ],
            'page'              =>  [
                                        'nullable',
                                        'integer',
                                    ],
            'no_of_records'     =>  [
                                        'nullable',
                                        'integer',
                                    ],
        ];
    }
}

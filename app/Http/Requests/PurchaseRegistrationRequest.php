<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Account;

class PurchaseRegistrationRequest extends FormRequest
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
            'supplier_account_id'   =>  [
                                            'required',
                                            Rule::in(Account::pluck('id')->toArray()),
                                        ],
            'purchase_date'         =>  [
                                            'required',
                                            'date_format:d-m-Y',
                                        ],
            'purchase_measure_type' =>  [
                                            'required',
                                            Rule::in([1, 2, 3]),
                                        ],
            'purchase_quantity'     =>  [
                                            'required',
                                            'numeric',
                                            'min:1',
                                            'max:1000',
                                        ],
            'purchase_rate'         =>  [
                                            'required',
                                            'numeric',
                                            'min:0.1',
                                            'max:50000',
                                        ],
            'purchase_bill'         =>  [
                                            'required',
                                            'numeric',
                                            'max:50000',
                                            'min:10',
                                        ],
            'purchase_discount'     =>  [
                                            'required',
                                            'numeric',
                                            'max:1000',
                                            'min:0',
                                        ],
            'purchase__total_bill'  =>  [
                                            'required',
                                            'numeric',
                                            'max:50000',
                                            'min:10',
                                        ],
        ];
    }
}

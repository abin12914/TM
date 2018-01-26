<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Truck;
use App\Models\Service;
use App\Models\Account;

class ExpenseRegistrationRequest extends FormRequest
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
            'transaction_type'      =>  [
                                            'required',
                                            Rule::in([1, 2]),
                                        ],
            'supplier_account_id'   =>  [
                                            'required_if:transaction_type,1',
                                            'nullable',
                                            Rule::in(Account::pluck('id')->toArray()),
                                        ],
            'date'                  =>  [
                                            'required',
                                            'date_format:d-m-Y',
                                        ],
            'truck_id'              =>  [
                                            'required',
                                            Rule::in(Truck::pluck('id')->toArray()),
                                        ],
            'service_id'            =>  [
                                            'required',
                                            Rule::in(Service::pluck('id')->toArray()),
                                        ],
            'description'           =>  [
                                            'nullable',
                                            'max:200',
                                        ],
            'bill_amount'           =>  [
                                            'required',
                                            'numeric',
                                            'min:1',
                                            'max:999999',
                                        ],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Account;

class SaleRegistrationRequest extends FormRequest
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
            'customer_account_id'   =>  [
                                            'required',
                                            Rule::in(Account::pluck('id')->toArray()),
                                        ],
            'sale_date'             =>  [
                                            'required',
                                            'date_format:d-m-Y',
                                        ],
            'sale_measure_type'     =>  [
                                            'required',
                                            Rule::in([1, 2, 3]),
                                        ],
            'sale_quantity'         =>  [
                                            'required',
                                            'numeric',
                                            'min:1',
                                            'max:1000',
                                        ],
            'sale_rate'             =>  [
                                            'required',
                                            'numeric',
                                            'min:0.1',
                                            'max:50000',
                                        ],
            'sale_bill'             =>  [
                                            'required',
                                            'numeric',
                                            'max:50000',
                                            'min:10',
                                        ],
            'sale_discount'         =>  [
                                            'required',
                                            'numeric',
                                            'max:1000',
                                            'min:0',
                                        ],
            'sale_total_bill'       =>  [
                                            'required',
                                            'numeric',
                                            'max:50000',
                                            'min:10',
                                        ],
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->checkCalculations()) {
                $validator->errors()->add('calculations', 'Something went wrong with the calculations!&emsp; Please try again after reloading the page');
            }
        });
    }

    public function checkCalculations() {
        $quanty     = $this->request->get("sale_quantity");
        $rate       = $this->request->get("sale_rate");
        $bill       = $this->request->get("sale_bill");
        $discount   = $this->request->get("sale_discount");
        $totalBill  = $this->request->get("sale_total_bill");

        if((($quanty * $rate) == $bill) && ($bill - $discount) == $totalBill) {
            return true;
        }
        return false;
    }
}

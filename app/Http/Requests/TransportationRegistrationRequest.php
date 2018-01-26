<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Truck;
use App\Models\Site;
use App\Models\Account;
use App\Models\Material;
use App\Models\Employee;

class TransportationRegistrationRequest extends FormRequest
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
            'truck_id'              =>  [
                                            'required',
                                            Rule::in(Truck::pluck('id')->toArray()),
                                        ],
            'transportation_date'   =>  [
                                            'required',
                                            'date_format:d-m-Y',
                                        ],
            'source_id'             =>  [
                                            'required',
                                            Rule::in(Site::pluck('id')->toArray()),
                                        ],
            'destination_id'        =>  [
                                            'required',
                                            'different:source_id',
                                            Rule::in(Site::pluck('id')->toArray()),
                                        ],
            'contractor_account_id' =>  [
                                            'required',
                                            Rule::in(Account::pluck('id')->toArray()),
                                        ],
            'rent_type'             =>  [
                                            'required',
                                            Rule::in([1, 2, 3]),
                                        ],
            'rent_measurement'      =>  [
                                            'required',
                                            'numeric',
                                            'min:1',
                                            'max:500',
                                        ],
            'rent_rate'             =>  [
                                            'required',
                                            'numeric',
                                            'min:0.1',
                                            'max:25000',
                                        ],
            'total_rent'            =>  [
                                            'required',
                                            'numeric',
                                            'max:25000',
                                            'min:10',
                                        ],
            'material_id'           =>  [
                                            'required',
                                            Rule::in(Material::pluck('id')->toArray()),
                                        ],
            'employee_id'           =>  [
                                            'required',
                                            Rule::in(Employee::pluck('id')->toArray()),
                                        ],
            'employee_wage'         =>  [
                                            'required',
                                            'numeric',
                                            'max:5000',
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
        $quanty     = $this->request->get("rent_measurement");
        $rate       = $this->request->get("rent_rate");
        $rentAmount = $this->request->get("total_rent");

        if(($quanty * $rate) == $rentAmount) {
            return true;
        }
        return false;
    }
}

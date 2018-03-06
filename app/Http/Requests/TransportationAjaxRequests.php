<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Truck;
use App\Models\Site;
use App\Models\Account;

class TransportationAjaxRequests extends FormRequest
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
        $customRules = [];

        if ($this->request->get('type') == 'driverByTruck') {
            $customRules = [
                'truck_id'  =>  [
                                    'required',
                                    Rule::in(Truck::pluck('id')->toArray()),
                                ],
            ];
        }

        if ($this->request->get('type') == 'contractorBySite') {
            $customRules = [
                'source_id'         =>  [
                                            'required',
                                            Rule::in(Site::pluck('id')->toArray()),
                                        ],
                'destination_id'    =>  [
                                            'required',
                                            Rule::in(Site::pluck('id')->toArray()),
                                        ],
            ];
        }

        if ($this->request->get('type') == 'rentDetailByCombo') {
            $customRules = [
                'truck_id'              =>  [
                                                'required',
                                                Rule::in(Truck::pluck('id')->toArray()),
                                            ],
                'source_id'             =>  [
                                                'required',
                                                Rule::in(Site::pluck('id')->toArray()),
                                            ],
                'destination_id'        =>  [
                                                'required',
                                                Rule::in(Site::pluck('id')->toArray())
                                            ],
                'contractor_account_id' =>  [
                                                'required',
                                                Rule::in(Account::pluck('id')->toArray()),
                                            ],
            ];
        }


        return $customRules;
    }

}

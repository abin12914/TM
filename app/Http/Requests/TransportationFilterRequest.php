<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Truck;
use App\Models\Site;
use App\Models\Account;
use App\Models\Material;
use App\Models\Employee;

class TransportationFilterRequest extends FormRequest
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
            'from_date'             =>  [
                                            'nullable',
                                            'date_format:d-m-Y',
                                        ],
            'to_date'               =>  [
                                            'nullable',
                                            'date_format:d-m-Y',
                                        ],
            'contractor_account_id' =>  [
                                            'nullable',
                                            Rule::in(Account::pluck('id')->toArray()),
                                        ],
            'truck_id'              =>  [
                                            'nullable',
                                            Rule::in(Truck::pluck('id')->toArray()),
                                        ],
            'source_id'             =>  [
                                            'nullable',
                                            Rule::in(Site::pluck('id')->toArray()),
                                        ],
            'destination_id'        =>  [
                                            'nullable',
                                            Rule::in(Site::pluck('id')->toArray()),
                                        ],
            'driver_id'             =>  [
                                            'nullable',
                                            Rule::in(Employee::pluck('id')->toArray()),
                                        ],
            'material_id'           =>  [
                                            'nullable',
                                            Rule::in(Material::pluck('id')->toArray()),
                                        ],
            'page'                  =>  [
                                            'nullable',
                                            'integer',
                                        ],
            'no_of_records'         =>  [
                                            'nullable',
                                            'min:2',
                                            'max:100',
                                            'integer',
                                        ],
        ];
    }
}

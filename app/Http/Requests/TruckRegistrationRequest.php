<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\TruckType;

class TruckRegistrationRequest extends FormRequest
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
            'reg_number'                    =>  [
                                                    'required',
                                                    'max:13',
                                                    'regex:(([A-Z]){2}(-)(?:[0-9]){2}( )(((?:[A-Z]){1,2}(-)([0-9]){1,4})|(([0-9]){1,4})))',
                                                    'unique:trucks,reg_number',
                                                ],
            'reg_number_state_code'         =>  [
                                                    'required',
                                                    Rule::in(DB::table('vehicle_registration_state_codes')->pluck('code')->toArray()),
                                                ],
            'reg_number_region_code'        =>  [
                                                    'required',
                                                    'max:99',
                                                    'min:1',
                                                    'digits:2',
                                                    'numeric',
                                                ],
            'reg_number_unique_alphabet'    =>  [
                                                    'nullable',
                                                    'max:2',
                                                ],
            'reg_number_unique_digit'       =>  [
                                                    'required',
                                                    'max:9999',
                                                    'min:1',
                                                    'integer',
                                                ],
            'description'                   =>  [
                                                    'nullable',
                                                    'max:200',
                                                ],
            'truck_type'                    =>  [
                                                    'required',
                                                    'integer',
                                                    Rule::in(TruckType::pluck('id')->toArray()),
                                                ],
            'volume'                        =>  [
                                                    'required',
                                                    'integer',
                                                    'max:999',
                                                ],
            'body_type'                     =>  [
                                                    'required',
                                                    Rule::in([1, 2, 3]),
                                                ],
            'insurance_date'                =>  [
                                                    'required',
                                                    'date_format:d-m-Y',
                                                ],
            'tax_date'                      =>  [
                                                    'required',
                                                    'date_format:d-m-Y',
                                                ],
            'permit_date'                   =>  [
                                                    'required',
                                                    'date_format:d-m-Y',
                                                ],
            'pollution_date'                =>  [
                                                    'required',
                                                    'date_format:d-m-Y',
                                                ],
        ];
    }
}
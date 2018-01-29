<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\TruckType;
use App\Repositories\TruckRepository;

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
        $bodyTypes = (new TruckRepository())->bodyTypes;

        return [
            'reg_number'                    =>  [
                                                    'required',
                                                    'max:13',
                                                    'regex:(([A-Z]){2}(-)(?:[0-9]){2}( )(((?:[A-Z]){1,2}(-)([0-9]){1,4})|(([0-9]){1,4})))',
                                                    Rule::unique('trucks', 'reg_number')->ignore($this->id),
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
                                                    Rule::in(array_keys($bodyTypes)),
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
            'fitness_date'                  =>  [
                                                    'required',
                                                    'date_format:d-m-Y',
                                                ],
            /*'pollution_date'                =>  [
                                                    'required',
                                                    'date_format:d-m-Y',
                                                ],*/
        ];
    }
}

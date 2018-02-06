<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\TruckType;
use App\Models\Truck;
use App\Repositories\TruckRepository;

class TruckFilterRequest extends FormRequest
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
            'truck_type_id' =>  [
                                    'nullable',
                                    Rule::in(TruckType::pluck('id')->toArray()),
                                ],
            'truck_id'      =>  [
                                    'nullable',
                                    Rule::in(Truck::pluck('id')->toArray()),
                                ],
            'page'          =>  [
                                    'nullable',
                                    'integer',
                                ],
            'no_of_records' =>  [
                                    'nullable',
                                    'min:2',
                                    'max:100',
                                    'integer',
                                ],
        ];
    }
}

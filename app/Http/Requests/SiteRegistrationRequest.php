<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SiteRegistrationRequest extends FormRequest
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
            'site_name'     =>  [
                                    'required',
                                    'max:200',
                                    'unique:sites,name',
                                ],
            'place'         =>  [
                                    'required',
                                    'max:200',
                                ],
            'address'       =>  [
                                    'nullable',
                                    'max:200',
                                ],
            'location_type' =>  [
                                    'required',
                                    Rule::in([1, 2, 3, 4, 5])
                                ],
        ];
    }
}

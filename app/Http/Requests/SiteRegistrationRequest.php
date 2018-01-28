<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Repositories\SiteRepository;

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
        $siteTypes  = (new SiteRepository())->siteTypes;

        return [
            'site_name'     =>  [
                                    'required',
                                    'max:200',
                                    Rule::unique('sites', 'name')->ignore($this->account_id),
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
                                    Rule::in(array_keys($siteTypes))
                                ],
        ];
    }
}

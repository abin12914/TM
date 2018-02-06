<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Site;
use App\Repositories\SiteRepository;

class SiteFilterRequest extends FormRequest
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
            'site_id'       =>  [
                                    'nullable',
                                    Rule::in(Site::pluck('id')->toArray()),
                                ],
            'site_type'     =>  [
                                    'nullable',
                                    Rule::in(array_keys($siteTypes)),
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

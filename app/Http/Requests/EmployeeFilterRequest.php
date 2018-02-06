<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Account;
use App\Repositories\EmployeeRepository;

class EmployeeFilterRequest extends FormRequest
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
        $wageTypes  = (new EmployeeRepository())->wageTypes;

        return [
            'employee_id'   =>  [
                                    'nullable',
                                    Rule::in(Account::pluck('id')->toArray()),
                                ],
            'wage_type'     =>  [
                                    'nullable',
                                    Rule::in(array_keys($wageTypes)),
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

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Auth;

class ProfileUpdateRequest extends FormRequest
{
    public $id;
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
        $this->id = Auth::user()->id;
        return [
            'user_name'     =>  [
                                    'nullable',
                                    'max:100',
                                    Rule::unique('users')->ignore($this->id),
                                ],
            'name'          =>  [
                                    'nullable',
                                    'max:100',
                                ],
            'phone'         =>  [
                                    'nullable',
                                    'numeric',
                                    'digits_between:10,14',
                                    Rule::unique('users')->ignore($this->id),
                                ],
            'image_file'    =>  [
                                    'nullable',
                                    'mimetypes:image/jpeg,image/jpg,image/bmp,image/png',
                                    'max:3000',
                                ],
            'old_password'  =>  [
                                    'required',
                                ],
            'password'      =>  [
                                    'nullable',
                                    'min:6',
                                    'max:16',
                                    'confirmed',
                                ],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    private $table = 'user';
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

            'email'    => 'bail|required|email',
            'password' => 'bail|required|between:5,100',
        ];
    }

    //======== MESSAGES =========
    public function messages()
    {
        return [
            // 'name.required' => 'Name: không được rỗng',
            // 'name.min' => 'Name: :input phải có ít nhất :min ký tự',
            // 'description.required'  => 'Description:  không được rỗng',
            // 'link.required'  => 'Link:  không được rỗng',
        ];
    }

    //======== ATTRIBUTES =========
    public function attributes()
    {
        return [
            // 'description' => 'Field description',
        ];
    }
}

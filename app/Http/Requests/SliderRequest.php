<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    private $table = 'slider';
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
        $id        = $this->id;
        $condThumb = "bail|required|image|between:5,100";
        $condName  = "bail|required|min:5|unique:$this->table,name";

        if (!empty($id)) {
            $condThumb = 'bail|image|max:500';
            $condName .= ",$id";
        }
        return [
            'name'        => $condName,
            'description' => 'bail|required|min:5',
            'link'        => 'bail|required|min:5|url',
            'status'      => 'bail|in:active,inactive',
            'thumb'       => $condThumb,
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

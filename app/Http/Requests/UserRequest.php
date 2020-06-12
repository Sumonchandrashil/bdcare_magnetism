<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        if(isset($this->id)){
            return [

                'user_name'=>'required',
                'email'=>'required|unique:users,email,'.$this->id.',id',
                'role_id'=>'required',
                'photo'=>'mimes:jpeg,bmp,png,jpg,JPG|max:2048',
            ];
        }

        return [
            'user_name'=>'required',
            'email'=>'required|unique:users',
            'role_id'=>'required',
            'password' => 'required|min:3|confirmed',
            'password_confirmation' => 'required|min:3',
            'photo'=>'mimes:jpeg,bmp,png,jpg,JPG|max:2048',

        ];
    }

    /*public function messages()
    {
        return $messages = [
            'user_name.regex'      => 'The :attribute must be one of the following types: "a-z and  - _ .": ',
        ];
    }*/
}

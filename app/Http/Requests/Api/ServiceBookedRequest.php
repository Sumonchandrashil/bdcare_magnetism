<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseApiRequest;

class ServiceBookedRequest extends BaseApiRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'service_id' => 'required|exists:services,id',
            'book_date' => 'required',
            'name' => 'required',
            'email' => 'required',
            'number' => 'required',
            'address' => 'required',
            'age' => 'required',
            'gender' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'service_id.required' => 'Service is not selected!',
            'service_id.exists' => 'Unknown Service is selected!',
            'book_date.required' => 'Book Date is required!',
            'name.required' => 'Name is required!',
            'email.required' => 'Email is required!',
            'number.required' => 'Phone number is required!',
            'address.required' => 'Address is required!',
            'age.required' => 'Age is required!',
            'gender.required' => 'Gender is required!',
        ];
    }

    public function filters()
    {
        return [
            'book_date' => 'trim|format_date:Y-m-d, Y-m-d',
            'name' => 'trim|escape|capitalize',
            'email' => 'trim|escape|lowercase',
            'number' => 'digit',
            'address' => 'trim|escape|capitalize',
            'age' => 'digit',
        ];
    }
}

<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseApiRequest;

class PackageBookedRequest extends BaseApiRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'package_id' => 'required|exists:health_packages,id',
            'book_date' => 'required',
            'name' => 'required',
            'email' => 'required',
            'number' => 'required',
            'address' => 'required',
            'age' => 'required',
            'gender' => 'required',
            'sample_collection' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'package_id.required' => 'Package is not selected!',
            'package_id.exists' => 'Unknown Package is selected!',
            'book_date.required' => 'Book Date is required!',
            'name.required' => 'Name is required!',
            'email.required' => 'Email is required!',
            'number.required' => 'Phone number is required!',
            'address.required' => 'Address is required!',
            'age.required' => 'Age is required!',
            'gender.required' => 'Gender is required!',
            'sample_collection.required' => 'Sample collection is required!',
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

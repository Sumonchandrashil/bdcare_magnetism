<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Waavi\Sanitizer\Laravel\SanitizesInput;

abstract class BaseApiRequest extends FormRequest
{
    use  SanitizesInput;

    public function validateResolved()
    {
        {
            $this->sanitize();
            parent::validateResolved();
        }
    }

    abstract public function rules();

    abstract public function authorize();

    protected function failedValidation(Validator $validator)
    {
        $response = new JsonResponse(['status' => false, 'message' => $validator->errors()->first()], 422);
        throw new ValidationException($validator, $response);
    }
}

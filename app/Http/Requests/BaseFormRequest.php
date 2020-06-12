<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Waavi\Sanitizer\Laravel\SanitizesInput;

abstract class BaseFormRequest extends FormRequest
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
}

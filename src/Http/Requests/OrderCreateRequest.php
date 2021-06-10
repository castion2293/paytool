<?php

namespace Pharaoh\Paytool\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Pharaoh\Paytool\Exceptions\PaytoolException;
use Pharaoh\Paytool\Rules\DriverExistsRule;

class OrderCreateRequest extends FormRequest
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
        return [
            'driver' => ['required', new DriverExistsRule()]
        ];
    }

    /**
     * 驗證錯誤訊息回傳
     *
     * @param Validator $validator
     * @throws PaytoolException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->messages();

        throw new PaytoolException('Validation Error: ' . json_encode($errors));
    }
}

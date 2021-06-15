<?php

namespace Pharaoh\Paytool\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Pharaoh\Paytool\Exceptions\PaytoolException;
use Pharaoh\Paytool\Rules\DriverExistsRule;
use Pharaoh\Paytool\Rules\PaymentExistsRule;

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
            'driver' => ['bail', 'required', new DriverExistsRule()],
            'choose_payment' => ['bail', 'required', new PaymentExistsRule($this->input('driver'))],
            'merchant_trade_no' => ['required'],
            'total_amount' => ['required', 'numeric'],
            'trade_desc' => ['required']
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

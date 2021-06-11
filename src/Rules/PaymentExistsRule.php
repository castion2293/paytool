<?php

namespace Pharaoh\Paytool\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class PaymentExistsRule implements Rule
{
    /**
     * 支付工具
     *
     * @var string
     */
    protected $driver = '';

    /**
     * 付款類型
     *
     * @var string
     */
    protected $payment = '';

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $driverName)
    {
        $this->driver = Str::of(class_basename($driverName))
            ->replaceLast('Driver', '')
            ->snake()
            ->__toString();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->payment = $value;

        $payments = config("paytool.driver.{$this->driver}.type");

        return isset($payments[$this->payment]);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "{$this->driver} driver payment: {$this->payment} is not exist";
    }
}

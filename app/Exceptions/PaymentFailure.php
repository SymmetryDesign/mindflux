<?php

namespace App\Exceptions;

class PaymentFailure extends IncompletePayment
{
    /**
     * Create a new PaymentFailure instance.
     *
     * @param $payment
     * @return static
     */
    public static function invalidPaymentMethod($payment)
    {
        return new static(
            $payment,
            'The payment attempt failed because of an invalid payment method.'
        );
    }
}

<?php

namespace App\Exceptions;

use Exception;

class IncompletePayment extends Exception
{
    /**
     * Create a new IncompletePayment instance.
     *
     * @param mixed $payment
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     * @return void
     */
    public function __construct($payment, $message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

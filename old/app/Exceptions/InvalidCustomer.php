<?php

namespace App\Exceptions;

use Exception;

class InvalidCustomer extends Exception
{
    /**
     * Create a new InvalidCustomer instance.
     *
     * @param \App\Models\Tenant $owner
     * @return static
     */
    public static function nonCustomer($owner)
    {
        return new static(class_basename($owner) . ' is not a billing customer.');
    }

    /**
     * Create a new InvalidCustomerException instance.
     *
     * @param \App\Models\Tenant $user
     * @return static
     */
    public static function exists($owner)
    {
        return new static(class_basename($owner) . " is already a customer with ID {$owner->customer_id}.");
    }
}

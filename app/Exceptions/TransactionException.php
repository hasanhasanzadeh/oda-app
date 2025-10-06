<?php

namespace App\Exceptions;

use Exception;

class TransactionException extends Exception
{
    public function __construct($message = "Transaction failed", $code = 400)
    {
        parent::__construct($message, $code);
    }
}

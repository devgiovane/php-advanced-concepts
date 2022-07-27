<?php


namespace Study\Domain\Exceptions;


class InvalidValueException extends \InvalidArgumentException
{
    public function __construct()
    {
        $message = "You value imputed is invalid";
        parent::__construct($message);
    }
}
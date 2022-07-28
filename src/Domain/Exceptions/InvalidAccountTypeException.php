<?php


namespace Study\Domain\Exceptions;


final class InvalidAccountTypeException extends \DomainException
{
    public function __construct(string $type)
    {
        $message = "Invalid account type: $type";
        parent::__construct($message);
    }
}
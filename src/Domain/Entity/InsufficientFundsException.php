<?php


namespace Study\Domain\Entity;
/**
 * Class InsufficientFundsException
 * @package Study\Domain\Entity
 */
class InsufficientFundsException extends \DomainException
{
    public function __construct(float $value, float $balance)
    {
        $message = "You tried to withdraw $value, but you only have $balance";
        parent::__construct($message);
    }
}
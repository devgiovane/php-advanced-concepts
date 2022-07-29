<?php


namespace Study\Domain\ValueObjects;


use Study\Domain\Exceptions\InvalidAccountTypeException;
/**
 * Class AccountType
 * @package Study\Domain\ValueObjects
 */
class AccountType
{
    public const CURRENT = 'current';
    public const SAVING = 'saving';

    /**
     * @var string
     */
    private $type;

    /**
     * AccountType constructor.
     * @param string $type
     */
    public function __construct(string $type)
    {
        if (!in_array($type, ['saving', 'current'])) {
            throw new InvalidAccountTypeException($type);
        }
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

}
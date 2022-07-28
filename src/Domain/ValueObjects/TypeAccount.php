<?php


namespace Study\Domain\ValueObjects;


use Study\Domain\Exceptions\InvalidAccountTypeException;
/**
 * Class TypeAccount
 * @package Study\Domain\ValueObjects
 */
class TypeAccount
{
    public const CURRENT = 'current';
    public const SAVING = 'saving';

    /**
     * @var string
     */
    private $type;

    /**
     * TypeAccount constructor.
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
<?php


namespace Study\Domain\Entities;
/**
 * Class Holder
 * @package Study\Domain\Entities
 */
final class Holder extends Person
{
    /**
     * @var Address
     */
    private $address;

    /**
     * Holder constructor.
     *
     * @param int|null $id
     * @param string $cpf
     * @param string $name
     * @param string $lastName
     * @param Address $address
     * @param string $type
     */
    public function __construct(?int $id, string $cpf, string $name, string $lastName, Address $address, string $type = "holder")
    {
        parent::__construct($id, $cpf, $name, $lastName, $type);
        $this->address = $address;
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

}
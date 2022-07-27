<?php


namespace Study\Domain\Entities;
/**
 * Class Holder
 * @package Study\Domain\Entities
 */
final class Holder extends Person implements Serializable
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
     */
    public function __construct(?int $id, string $cpf, string $name, string $lastName, Address $address)
    {
        parent::__construct($id, $cpf, $name, $lastName);
        $this->address = $address;
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array(
            'id' => $this->getId(),
            'cpf' => $this->getCpf(),
            'name' => $this->getFullName()
        );
    }
}
<?php


namespace Study\Domain\Entity;
/**
 * Class Employee
 * @package Study\Domain\Entity
 */
final class Employee extends Person
{
    /**
     * @var string
     */
    private $office;

    /**
     * @var float
     */
    private $wage;

    /**
     * Employee constructor.
     *
     * @param int|null $id
     * @param string $cpf
     * @param string $name
     * @param string $lastName
     * @param string $office
     * @param float $wage
     */
    public function __construct(?int $id, string $cpf, string $name, string $lastName, string $office, float $wage)
    {
        parent::__construct($id, $cpf, $name, $lastName);
        $this->office = $office;
        $this->wage = $wage;
    }

    /**
     * @return string
     */
    public function getOffice(): string
    {
        return $this->office;
    }

    /**
     * @return float
     */
    public function getWage(): float
    {
        return $this->wage;
    }

    /**
     * @return float
     */
    public function bonus(): float
    {
        return $this->getWage() * 0.1;
    }

}
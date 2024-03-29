<?php


namespace Study\Domain\Entities;
/**
 * Class Employee
 * @package Study\Domain\Entities
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
     * @param string $type
     */
    public function __construct(?int $id, string $cpf, string $name, string $lastName, string $office, float $wage, string $type = "employee")
    {
        parent::__construct($id, $cpf, $name, $lastName, $type);
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
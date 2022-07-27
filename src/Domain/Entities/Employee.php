<?php


namespace Study\Domain\Entities;
/**
 * Class Employee
 * @package Study\Domain\Entities
 */
final class Employee extends Person implements Serializable
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

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array(
            'id' => $this->getId(),
            'cpf' => $this->getCpf(),
            'name' => $this->getFullName(),
            'office' => $this->getOffice(),
            'wage' => $this->getWage()
        );
    }
}
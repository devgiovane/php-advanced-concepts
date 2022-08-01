<?php


namespace Study\Application\UseCases\CreateEmployee;
/**
 * Class InputBoundary
 * @package Study\Application\UseCases\CreateEmployee
 */
final class InputBoundary
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $cpf;

    /**
     * @var string
     */
    private $office;

    /**
     * @var float
     */
    private $wage;

    /**
     * InputBoundary constructor.
     * @param string $name
     * @param string $lastName
     * @param string $cpf
     * @param string $office
     * @param float $wage
     */
    public function __construct(string $name, string $lastName, string $cpf, string $office, float $wage)
    {
        $this->name = $name;
        $this->lastName = $lastName;
        $this->cpf = $cpf;
        $this->office = $office;
        $this->wage = $wage;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getCpf(): string
    {
        return $this->cpf;
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
}
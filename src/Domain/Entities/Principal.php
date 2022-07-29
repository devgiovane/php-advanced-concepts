<?php


namespace Study\Domain\Entities;
/**
 * Class Principal
 * @package Study\Domain\Entities
 */
final class Principal extends Person
{
    /**
     * @var float
     */
    private $wage;

    /**
     * @var string
     */
    private $password;

    /**
     * Employee constructor.
     *
     * @param int|null $id
     * @param string $cpf
     * @param string $name
     * @param string $lastName
     * @param string $password
     * @param float $wage
     * @param string $type
     */
    public function __construct(?int $id, string $cpf, string $name, string $lastName, string $password, float $wage, string $type = "principal")
    {
        parent::__construct($id, $cpf, $name, $lastName, $type);
        $this->password = $password;
        $this->wage = $wage;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
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
        return $this->getWage() * 0.5;
    }

    /**
     * @param string $password
     * @return bool
     */
    public function isAuthenticate(string $password): bool
    {
        return $this->getPassword() === $password;
    }

}
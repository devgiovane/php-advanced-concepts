<?php


namespace Study\Domain\Entities;



use Study\Infrastructure\Repository\EmployeeRepository;
use Study\Infrastructure\Repository\HolderRepository;
use Study\Infrastructure\Repository\PrincipalRepository;

/**
 * Class Person
 * @package Study\Domain\Entities
 */
abstract class Person
{
    public const TYPES = [
        'holder' => HolderRepository::class,
        'employee' => EmployeeRepository::class,
        'principal' => PrincipalRepository::class
    ];
    /**
     * @var int|null
     */
    protected $id;

    /**
     * @var string
     */
    private $cpf;

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
    private $type;

    /**
     * Person constructor.
     *
     * @param int|null $id
     * @param string $cpf
     * @param string $name
     * @param string $lastName
     * @param string $type
     */
    public function __construct(?int $id, string $cpf, string $name, string $lastName, string $type)
    {
        $this->id = $id;
        $this->cpf = $cpf;
        $this->name = $name;
        $this->lastName = $lastName;
        $this->type = $type;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getCpf(): string
    {
        return $this->cpf;
    }

    /**
     * @param string $cpf
     */
    public function setCpf(string $cpf): void
    {
        $this->cpf = $cpf;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->getName() . " " . $this->getLastName();
    }

}
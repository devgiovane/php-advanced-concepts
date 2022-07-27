<?php


namespace Study\Domain\Entities;
/**
 * Class Person
 * @package Study\Domain\Entities
 */
abstract class Person
{
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
     * Person constructor.
     *
     * @param int|null $id
     * @param string $cpf
     * @param string $name
     * @param string $lastName
     */
    public function __construct(?int $id, string $cpf, string $name, string $lastName)
    {
        $this->id = $id;
        $this->cpf = $cpf;
        $this->name = $name;
        $this->lastName = $lastName;
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
    public function getFullName(): string
    {
        return $this->getName() . " " . $this->getLastName();
    }

}
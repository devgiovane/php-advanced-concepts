<?php


namespace Study\Application\UseCases\CreateHolder;


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
    private $city;

    /**
     * @var string
     */
    private $road;

    /**
     * @var int
     */
    private $number;

    /**
     * InputBoundary constructor.
     * @param string $name
     * @param string $lastName
     * @param string $cpf
     * @param string $city
     * @param string $road
     * @param int $number
     */
    public function __construct(string $name, string $lastName, string $cpf, string $city, string $road, int $number)
    {
        $this->name = $name;
        $this->lastName = $lastName;
        $this->cpf = $cpf;
        $this->city = $city;
        $this->road = $road;
        $this->number = $number;
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
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getRoad(): string
    {
        return $this->road;
    }

    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
    }

}
<?php


namespace Study\Domain\Entities;


class Address
{
    /**
     * @var int|null
     */
    protected $id;

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
     * Address constructor.
     *
     * @param int|null $id
     * @param string $city
     * @param string $road
     * @param int $number
     */
    public function __construct(?int $id, string $city, string $road, int $number)
    {
        $this->id = $id;
        $this->city = $city;
        $this->road = $road;
        $this->number = $number;
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

    public function __toString()
    {
        return "{$this->getRoad()}, {$this->getNumber()}, {$this->getCity()}";
    }

}
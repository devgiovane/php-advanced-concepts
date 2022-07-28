<?php


namespace Study\Application\UseCases\CreateAccount;


final class OutputBoundary
{
    /**
     * @var int
     */
    private $id;

    /**
     * OutputBoundary constructor.
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

}
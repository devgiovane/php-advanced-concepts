<?php


namespace Study\Application\UseCases\MakePayment;
/**
 * Class OutputBoundary
 * @package Study\Application\UseCases\MakePayment
 */
final class OutputBoundary
{
    /**
     * @var string
     */
    private $status;

    /**
     * OutputBoundary constructor.
     * @param string $status
     */
    public function __construct(string $status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

}
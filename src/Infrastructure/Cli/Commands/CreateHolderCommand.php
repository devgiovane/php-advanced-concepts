<?php


namespace Study\Infrastructure\Cli\Commands;


use Study\Application\UseCases\CreateHolder\CreateHolder;
use Study\Application\UseCases\CreateHolder\InputBoundary;
/**
 * Class CreateHolderCommand
 * @package Study\Infrastructure\Cli\Commands
 */
final class CreateHolderCommand
{
    /**
     * @var CreateHolder
     */
    private $useCase;

    /**
     * CreateHolderCommand constructor.
     * @param CreateHolder $useCase
     */
    public function __construct(CreateHolder $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * @param string $name
     * @param string $lastName
     * @param string $cpf
     * @param string $city
     * @param string $road
     * @param int $number
     * @return array
     */
    public function handle(string $name, string $lastName, string $cpf, string $city, string $road, int $number): array
    {
        $inputBoundary = new InputBoundary($name, $lastName, $cpf, $city, $road, $number);
        $output = $this->useCase->handle($inputBoundary);
        return [
            "id" => $output->getId()
        ];
    }
}
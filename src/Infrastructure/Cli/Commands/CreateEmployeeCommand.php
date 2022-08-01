<?php


namespace Study\Infrastructure\Cli\Commands;


use Study\Application\UseCases\CreateEmployee\CreateEmployee;
use Study\Application\UseCases\CreateEmployee\InputBoundary;

/**
 * Class CreateEmployeeCommand
 * @package Study\Infrastructure\Cli\Commands
 */
final class CreateEmployeeCommand
{
    /**
     * @var CreateEmployee
     */
    private $useCase;

    /**
     * CreateEmployeeCommand constructor.
     * @param CreateEmployee $useCase
     */
    public function __construct(CreateEmployee $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * @param string $name
     * @param string $lastName
     * @param string $cpf
     * @param string $office
     * @param int $wage
     * @return array
     */
    public function handle(string $name, string $lastName, string $cpf, string $office, int $wage): array
    {
        $inputBoundary = new InputBoundary($name, $lastName, $cpf, $office, $wage);
        $output = $this->useCase->handle($inputBoundary);
        return [
            "id" => $output->getId()
        ];
    }
}
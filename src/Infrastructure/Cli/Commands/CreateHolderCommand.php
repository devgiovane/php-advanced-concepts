<?php


namespace Study\Infrastructure\Cli\Commands;


use Study\Application\UseCases\CreateHolder\CreateHolder;
use Study\Application\UseCases\CreateHolder\InputBoundary;


final class CreateHolderCommand
{
    /**
     * @var CreateHolder
     */
    private $useCase;

    public function __construct(CreateHolder $useCase)
    {
        $this->useCase = $useCase;
    }

    public function handle(): array
    {
        $inputBoundary = new InputBoundary(
            "Giovane", "Silva", "123.456.789-00", "São Paulo", "Rua um", 123
        );
        $output = $this->useCase->handle($inputBoundary);
        return [
            "id" => $output->getId()
        ];
    }
}
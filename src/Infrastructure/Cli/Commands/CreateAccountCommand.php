<?php


namespace Study\Infrastructure\Cli\Commands;


use Study\Application\UseCases\CreateAccount\CreateAccount;
use Study\Application\UseCases\CreateAccount\InputBoundary;


final class CreateAccountCommand
{
    /**
     * @var CreateAccount
     */
    private $useCase;

    public function __construct(CreateAccount $useCase)
    {
        $this->useCase = $useCase;
    }

    public function handle(): array
    {
        $inputBoundary = new InputBoundary(
            1, 10000, "current"
        );
        $output = $this->useCase->handle($inputBoundary);
        return [
            "id" => $output->getId()
        ];
    }
}
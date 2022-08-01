<?php


namespace Study\Infrastructure\Cli\Commands;


use Study\Application\UseCases\CreateAccount\CreateAccount;
use Study\Application\UseCases\CreateAccount\InputBoundary;
/**
 * Class CreateAccountCommand
 * @package Study\Infrastructure\Cli\Commands
 */
final class CreateAccountCommand
{
    /**
     * @var CreateAccount
     */
    private $useCase;

    /**
     * CreateAccountCommand constructor.
     * @param CreateAccount $useCase
     */
    public function __construct(CreateAccount $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * @param int $person
     * @param int $balance
     * @param string $type
     * @return array
     */
    public function handle(int $person, int $balance, string $type): array
    {
        $inputBoundary = new InputBoundary($person, $balance, $type);
        $output = $this->useCase->handle($inputBoundary);
        return [
            "id" => $output->getId()
        ];
    }
}
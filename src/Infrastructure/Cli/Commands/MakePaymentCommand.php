<?php


namespace Study\Infrastructure\Cli\Commands;


use Study\Application\UseCases\MakePayment\InputBoundary;
use Study\Application\UseCases\MakePayment\MakePayment;
/**
 * Class MakePaymentCommand
 * @package Study\Infrastructure\Cli\Commands
 */
final class MakePaymentCommand
{
    /**
     * @var MakePayment
     */
    private $useCase;

    /**
     * MakePaymentCommand constructor.
     * @param MakePayment $useCase
     */
    public function __construct(MakePayment $useCase)
    {
        $this->useCase = $useCase;
    }

    public function handle(int $account, int $employee): array
    {
        $inputBoundary = new InputBoundary($account, $employee);
        $output = $this->useCase->handle($inputBoundary);
        return [
            'success' => true
        ];
    }
}
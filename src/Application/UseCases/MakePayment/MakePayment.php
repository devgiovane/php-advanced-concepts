<?php


namespace Study\Application\UseCases\MakePayment;


use Study\Domain\Entities\Employee;
use Study\Domain\Entities\AccountCurrent;
use Study\Domain\Entities\AccountSaving;
use Study\Domain\Repository\PersonRepository;
use Study\Domain\Repository\AccountSavingRepository;
use Study\Domain\Repository\AccountCurrentRepository;
/**
 * Class MakePayment
 * @package Study\Application\UseCases\MakePayment
 */
final class MakePayment
{
    /**
     * @var PersonRepository
     */
    private $personRepository;

    /**
     * @var AccountCurrentRepository
     */
    private $accountCurrentRepository;

    /**
     * @var AccountSavingRepository
     */
    private $accountSavingRepository;

    /**
     * MakePayment constructor.
     * @param PersonRepository $personRepository
     * @param AccountCurrentRepository $accountCurrentRepository
     * @param AccountSavingRepository $accountSavingRepository
     */
    public function __construct(
        PersonRepository $personRepository,
        AccountCurrentRepository $accountCurrentRepository,
        AccountSavingRepository $accountSavingRepository
    )
    {
        $this->personRepository = $personRepository;
        $this->accountCurrentRepository = $accountCurrentRepository;
        $this->accountSavingRepository = $accountSavingRepository;
    }

    /**
     * @param InputBoundary $inputBoundary
     * @return OutputBoundary
     */
    public function handle(InputBoundary $inputBoundary): OutputBoundary
    {
        /** @var AccountCurrent $account */
        $account = $this->accountCurrentRepository->find($inputBoundary->getAccount());
        /** @var Employee $employee */
        $employee = $this->personRepository->find($inputBoundary->getEmployee());
        /** @var AccountSaving $accountEmployee */
        $accountEmployee = $this->accountSavingRepository->findByPerson($employee->getId());

        $account->transfer($employee->getWage(), $accountEmployee);

        $this->accountSavingRepository->update($accountEmployee);
        $this->accountCurrentRepository->update($account);
        return new OutputBoundary("success");
    }

}
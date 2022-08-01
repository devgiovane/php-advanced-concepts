<?php


namespace Study\Application\UseCases\CreateAccount;


use Study\Domain\Entities\AccountCurrent;
use Study\Domain\Entities\AccountSaving;
use Study\Domain\ValueObjects\AccountType;
use Study\Domain\Repository\AccountRepository;
use Study\Domain\Repository\PersonRepository;
/**
 * Class CreateAccount
 * @package Study\Application\UseCases\CreateAccount
 */
final class CreateAccount
{
    /**
     * @var AccountRepository
     */
    private $accountRepository;

    /**
     * @var PersonRepository
     */
    private $personRepository;

    /**
     * CreateAccount constructor.
     * @param AccountRepository $accountRepository
     * @param PersonRepository $personRepository
     */
    public function __construct(AccountRepository $accountRepository, PersonRepository $personRepository)
    {
        $this->personRepository = $personRepository;
        $this->accountRepository = $accountRepository;
    }

    /**
     * @param InputBoundary $inputBoundary
     * @return OutputBoundary
     */
    public function handle(InputBoundary $inputBoundary): OutputBoundary
    {
        $accountType = new AccountType($inputBoundary->getType());
        $holder = $this->personRepository->find($inputBoundary->getPerson());
        if ($accountType->getType() === AccountType::SAVING) {
            $account = new AccountSaving(null, $holder, $inputBoundary->getBalance());
        } else {
            $account = new AccountCurrent(null, $holder, $inputBoundary->getBalance());
        }
        $idSaving = $this->accountRepository->save($account);
        return new OutputBoundary($idSaving);
    }

}
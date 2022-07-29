<?php


namespace Study\Application\UseCases\CreateAccount;


use Study\Domain\Entities\AccountCurrent;
use Study\Domain\Entities\AccountSaving;
use Study\Domain\Repository\HolderRepository;
use Study\Domain\Repository\AccountRepository;
use Study\Domain\ValueObjects\AccountType;
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
     * @var HolderRepository
     */
    private $holderRepository;

    public function __construct(AccountRepository $accountRepository, HolderRepository $holderRepository)
    {
        $this->holderRepository = $holderRepository;
        $this->accountRepository = $accountRepository;
    }

    public function handle(InputBoundary $inputBoundary): OutputBoundary
    {
        $accountType = new AccountType($inputBoundary->getType());
        $holder = $this->holderRepository->find($inputBoundary->getHolder());
        if ($accountType->getType() === AccountType::SAVING) {
            $account = new AccountSaving(null, $holder, $inputBoundary->getBalance());
        } else {
            $account = new AccountCurrent(null, $holder, $inputBoundary->getBalance());
        }
        $idSaving = $this->accountRepository->save($account);
        return new OutputBoundary($idSaving);
    }
}
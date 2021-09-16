<?php


namespace Study\Service;


use Study\Domain\Entity\AccountSaving;
use Study\Domain\Entity\AccountCurrent;
use Study\Domain\Infrastructure\Persistence\ConnectionFactory;
use Study\Domain\Infrastructure\Repository\AccountSavingRepository;
use Study\Domain\Infrastructure\Repository\AccountCurrentRepository;
/**
 * Class AccountService
 * @package Study\Service
 */
class AccountService
{
    /**
     * @var ConnectionFactory
     */
    private $connectionFactory;

    /**
     * @var AccountCurrentRepository
     */
    private $accountCurrentRepository;

    /**
     * @var AccountSavingRepository
     */
    private $accountSavingRepository;

    /**
     * HolderService constructor.
     * @param ConnectionFactory $connectionFactory
     */
    public function __construct(ConnectionFactory $connectionFactory)
    {
        $this->connectionFactory = $connectionFactory;
        $this->connectionFactory->create();
        $this->accountSavingRepository = new AccountSavingRepository($this->connectionFactory);
        $this->accountCurrentRepository = new AccountCurrentRepository($this->connectionFactory);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function listOneCurrent(int $id): AccountCurrent
    {
        return $this->accountCurrentRepository->find($id);
    }

    /**
     * @return array
     */
    public function listAllCurrent(): array
    {
        return $this->accountCurrentRepository->findAll();
    }

    /**
     * @param AccountCurrent $accountCurrent
     * @return int|null
     */
    public function createCurrent(AccountCurrent $accountCurrent): ?int
    {
        return $this->accountCurrentRepository->save($accountCurrent);
    }

    /**
     * @param int|null $id
     * @return AccountSaving
     */
    public function listOneSaving(int $id): AccountSaving
    {
        return $this->accountSavingRepository->find($id);
    }

    /**
     * @return array
     */
    public function listAllSaving(): array
    {
        return $this->accountSavingRepository->findAll();
    }

    /**
     * @param AccountSaving $accountSaving
     * @return int|null
     */
    public function createSaving(AccountSaving $accountSaving): ?int
    {
        return $this->accountSavingRepository->save($accountSaving);
    }

}
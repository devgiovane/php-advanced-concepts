<?php


namespace Study\Infrastructure\Repository;


use Study\Domain\Entities\Account;
use Study\Domain\Entities\AccountSaving;
use Study\Infrastructure\Persistence\ConnectionFactory;
use Study\Domain\Repository\AccountSavingRepository as AccountSavingRepositoryInterface;
/**
 * Class AccountSavingRepository
 * @package Study\Infrastructure\Repository
 */
class AccountSavingRepository implements AccountSavingRepositoryInterface
{
    /**
     * @var ConnectionFactory
     */
    private $connectionFactory;

    /**
     * @var PersonRepository
     */
    private $personRepository;

    /**
     * HolderRepository constructor.
     * @param ConnectionFactory $connectionFactory
     */
    public function __construct(ConnectionFactory $connectionFactory)
    {
        $this->connectionFactory = $connectionFactory;
        $this->personRepository = new PersonRepository($this->connectionFactory);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id): AccountSaving
    {
        $query = "
            SELECT * FROM account_saving AS acs
            INNER JOIN account AS a ON a.id = acs.id 
            WHERE a.id = :id;
        ";
        $this->connectionFactory->prepare($query)
            ->bind(':id', $id);

        $this->connectionFactory->execute();
        return $this->hydrateAccount()[0];
    }

    /**
     * @param int $personID
     * @return AccountSaving
     */
    public function findByPerson(int $personID): AccountSaving
    {
        $query = "
            SELECT * FROM account_saving AS acs
            INNER JOIN account AS a ON a.id = acs.id 
            WHERE a.person_id = :person_id;
        ";
        $this->connectionFactory->prepare($query)
            ->bind(':person_id', $personID);

        $this->connectionFactory->execute();
        return $this->hydrateAccount()[0];
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        $query = "
            SELECT * FROM account_saving AS acs 
            INNER JOIN account AS a ON a.id = acs.id
        ";
        $this->connectionFactory->query($query);
        return $this->hydrateAccount();
    }

    /**
     * @return array
     */
    private function hydrateAccount(): array
    {
        $accountList = [];
        $data = $this->connectionFactory->getAll();
        foreach ($data as $item) {
            $accountList[] = new AccountSaving(
                (int) $item['id'],
                $this->personRepository->find((int) $item['person_id']),
                (float) $item['balance'],
                (string) $item['type']
            );

        }
        return $accountList;
    }

    /**
     * @param Account $account
     * @return int|null
     */
    public function save(Account $account): ?int
    {
        $this->connectionFactory->beginTransaction();
        $query = "INSERT INTO account (person_id, balance, type) VALUES (:person_id, :balance, :type);";
        $this->connectionFactory->prepare($query)
            ->bind(':person_id', $account->getPerson()->getId())
            ->bind(':balance', $account->getBalance())
            ->bind(':type', $account->getType());
        $isAccountCreated = $this->connectionFactory->execute();
        if (!$isAccountCreated) {
            $this->connectionFactory->rollBack();
            return null;
        }
        $isAccountId = $this->connectionFactory->getLastInsertedId();
        $query = "INSERT INTO account_saving (id) VALUES (:id);";
        $this->connectionFactory->prepare($query)
            ->bind(':id', $isAccountId);
        $isAccountSavingCreated = $this->connectionFactory->execute();
        if (!$isAccountSavingCreated) {
            $this->connectionFactory->rollBack();
            return null;
        }
        $this->connectionFactory->commit();
        return $isAccountId;
    }

    /**
     * @param Account $account
     * @return bool
     */
    public function update(Account $account): bool
    {
        $query = "UPDATE account SET balance = :balance WHERE id = :id;";
        $this->connectionFactory->prepare($query)
            ->bind(':balance', $account->getBalance())
            ->bind(':id', $account->getId());
        return $this->connectionFactory->execute();
    }

    /**
     * @param Account $account
     * @return bool
     */
    public function remove(Account $account): bool
    {
        $query = "DELETE FROM account WHERE id = :id";
        $this->connectionFactory->prepare($query)
            ->bind(':id', $account->getId());

        return $this->connectionFactory->execute();
    }
}
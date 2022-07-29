<?php


namespace Study\Infrastructure\Repository;


use Study\Domain\Entities\Account;
use Study\Domain\Entities\AccountCurrent;
use Study\Infrastructure\Persistence\ConnectionFactory;
use Study\Domain\Repository\AccountCurrentRepository as AccountCurrentRepositoryInterface;
/**
 * Class AccountCurrentRepository
 * @package Study\Infrastructure\Repository
 */
class AccountCurrentRepository implements AccountCurrentRepositoryInterface
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
    public function find(int $id): AccountCurrent
    {
        $query = "
            SELECT * FROM account_current AS ac
            INNER JOIN account AS a ON a.id = ac.id 
            WHERE a.id = :id;
        ";
        $this->connectionFactory->prepare($query)
            ->bind(':id', $id);

        $this->connectionFactory->execute();
        return $this->hydrateAccount()[0];
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        $query = "
            SELECT * FROM account_current AS ac
            INNER JOIN account AS a ON a.id = ac.id 
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
            $accountList[] = new AccountCurrent(
                (int) $item['id'],
                $this->personRepository->find((int) $item['holder_id']),
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
        $query = "INSERT INTO account (holder_id, balance, type) VALUES (:holder_id, :balance, :type);";
        $this->connectionFactory->prepare($query)
            ->bind(':holder_id', $account->getHolder()->getId())
            ->bind(':balance', $account->getBalance())
            ->bind(':type', $account->getType());
        $isAccountCreated = $this->connectionFactory->execute();
        if (!$isAccountCreated) {
            $this->connectionFactory->rollBack();
            return null;
        }
        $isAccountId = $this->connectionFactory->getLastInsertedId();
        $query = "INSERT INTO account_current (id) VALUES (:id);";
        $this->connectionFactory->prepare($query)
            ->bind(':id', $isAccountId);
        $isAccountCurrentCreated = $this->connectionFactory->execute();
        if (!$isAccountCurrentCreated) {
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
    public function remove(Account $account): bool
    {
        $query = "DELETE FROM account WHERE id = :id";
        $this->connectionFactory->prepare($query)
            ->bind(':id', $account->getId());

        return $this->connectionFactory->execute();
    }
}
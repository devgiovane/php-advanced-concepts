<?php


namespace Study\Infrastructure\Repository;


use Study\Domain\Entities\Account;
use Study\Domain\Entities\Holder;
use Study\Domain\Entities\Address;
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
     * HolderRepository constructor.
     * @param ConnectionFactory $connectionFactory
     */
    public function __construct(ConnectionFactory $connectionFactory)
    {
        $this->connectionFactory = $connectionFactory;
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
            INNER JOIN person AS p ON a.holder_id = p.id
            INNER JOIN holder AS h ON p.id = h.id   
            INNER JOIN address AS ad ON h.id_address = ad.id
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
            SELECT * FROM account_saving AS acs 
            INNER JOIN account AS a ON a.id = acs.id 
            INNER JOIN person AS p ON a.holder_id = p.id
            INNER JOIN holder AS h ON p.id = h.id   
            INNER JOIN address AS ad ON h.address_id = ad.id;
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
                new Holder(
                    (int) $item['id_holder'],
                    (string) $item['cpf'],
                    (string) $item['name'],
                    (string) $item['last_name'],
                    new Address(
                        (int) $item['id_address'],
                        (string) $item['city'],
                        (string) $item['road'],
                        (int) $item['number']
                    )
                ),
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
        $query = "INSERT INTO account (holder_id, balance, type) VALUES (:id_holder, :balance, :type);";
        $this->connectionFactory->prepare($query)
            ->bind(':id_holder', $account->getHolder()->getId())
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
    public function remove(Account $account): bool
    {
        $query = "DELETE FROM account WHERE id = :id";
        $this->connectionFactory->prepare($query)
            ->bind(':id', $account->getId());

        return $this->connectionFactory->execute();
    }

}
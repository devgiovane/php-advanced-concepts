<?php


namespace Study\Domain\Infrastructure\Repository;


use Study\Domain\Entity\Holder;
use Study\Domain\Entity\Address;
use Study\Domain\Entity\AccountCurrent;
use Study\Domain\Infrastructure\Persistence\ConnectionFactory;
/**
 * Class AccountCurrentRepository
 * @package Study\Domain\Infrastructure\Repository
 */
class AccountCurrentRepository implements \Study\Repository\AccountCurrentRepository
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
    public function find(int $id): AccountCurrent
    {
        $query = "
            SELECT * FROM account_current AS ac
            INNER JOIN account AS a ON a.id = ac.id 
            INNER JOIN person AS p ON a.id_holder = p.id
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
            SELECT * FROM account_current AS ac
            INNER JOIN account AS a ON a.id = ac.id 
            INNER JOIN person AS p ON a.id_holder = p.id
            INNER JOIN holder AS h ON p.id = h.id   
            INNER JOIN address AS ad ON h.id_address = ad.id;
        ";
        $this->connectionFactory->query($query);
        return $this->hydrateAccount();
    }

    /**
     * @return array
     */
    private function hydrateAccount()
    {
        $accountList = [];
        $data = $this->connectionFactory->getAll();
        foreach ($data as $item) {
            $accountList[] = new AccountCurrent(
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
                (float) $item['balance']
            );

        }
        return $accountList;
    }

    /**
     * @param AccountCurrent $accountCurrent
     * @return int|null
     */
    public function save(AccountCurrent $accountCurrent): ?int
    {
        $this->connectionFactory->beginTransaction();

        $isAccountCurrentCreated = false;

        $query = "INSERT INTO account (id_holder, balance) VALUES (:id_holder, :balance);";
        $this->connectionFactory->prepare($query)
            ->bind(':id_holder', $accountCurrent->getHolder()->getId())
            ->bind(':balance', $accountCurrent->getBalance());

        $isAccountCreated = $this->connectionFactory->execute();

        if($isAccountCreated) {
            $isAccountId = $this->connectionFactory->getLastInsertedId();

            $query = "INSERT INTO account_current (id) VALUES (:id);";
            $this->connectionFactory->prepare($query)
                ->bind(':id', $isAccountId);

            $isAccountCurrentCreated = $this->connectionFactory->execute();
        }

        if($isAccountCurrentCreated) {
            $this->connectionFactory->commit();
            return $isAccountCreated;
        }

        $this->connectionFactory->rollBack();
        return null;
    }

    /**
     * @param AccountCurrent $accountCurrent
     * @return bool
     */
    public function remove(AccountCurrent $accountCurrent): bool
    {
        $query = "DELETE FROM account WHERE id = :id";
        $this->connectionFactory->prepare($query)
            ->bind(':id', $accountCurrent->getId());

        return $this->connectionFactory->execute();
    }
}
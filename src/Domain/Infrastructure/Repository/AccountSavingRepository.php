<?php


namespace Study\Domain\Infrastructure\Repository;


use Study\Domain\Entity\Holder;
use Study\Domain\Entity\Address;
use Study\Domain\Entity\AccountSaving;
use Study\Domain\Infrastructure\Persistence\ConnectionFactory;
/**
 * Class AccountSavingRepository
 * @package Study\Domain\Infrastructure\Repository
 */
class AccountSavingRepository implements \Study\Repository\AccountSavingRepository
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
            SELECT * FROM account_saving AS acs 
            INNER JOIN account AS a ON a.id = acs.id 
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
                (float) $item['balance']
            );

        }
        return $accountList;
    }

    /**
     * @param AccountSaving $accountSaving
     * @return int|null
     */
    public function save(AccountSaving $accountSaving): ?int
    {
        $this->connectionFactory->beginTransaction();

        $isAccountSavingCreated = false;

        $query = "INSERT INTO account (id_holder, balance) VALUES (:id_holder, :balance);";
        $this->connectionFactory->prepare($query)
            ->bind(':id_holder', $accountSaving->getHolder()->getId())
            ->bind(':balance', $accountSaving->getBalance());

        $isAccountCreated = $this->connectionFactory->execute();

        if($isAccountCreated) {
            $isAccountId = $this->connectionFactory->getLastInsertedId();

            $query = "INSERT INTO account_saving (id) VALUES (:id);";
            $this->connectionFactory->prepare($query)
                ->bind(':id', $isAccountId);

            $isAccountSavingCreated = $this->connectionFactory->execute();
        }

        if($isAccountSavingCreated) {
            $this->connectionFactory->commit();
            return $isAccountCreated;
        }

        $this->connectionFactory->rollBack();
        return null;
    }

    /**
     * @param AccountSaving $accountSaving
     * @return bool
     */
    public function remove(AccountSaving $accountSaving): bool
    {
        $query = "DELETE FROM account WHERE id = :id";
        $this->connectionFactory->prepare($query)
            ->bind(':id', $accountSaving->getId());

        return $this->connectionFactory->execute();
    }

}
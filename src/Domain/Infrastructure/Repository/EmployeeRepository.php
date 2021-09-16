<?php


namespace Study\Domain\Infrastructure\Repository;


use Study\Domain\Entity\Employee;
use Study\Domain\Infrastructure\Persistence\ConnectionFactory;
/**
 * Class EmployeeRepository
 * @package Study\Domain\Infrastructure\Repository
 */
class EmployeeRepository implements \Study\Repository\EmployeeRepository
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
    public function find(int $id)
    {
        $query = "
            SELECT * FROM person AS p 
            INNER JOIN employee AS e ON p.id = e.id 
            WHERE p.id = :id;
        ";
        $this->connectionFactory->prepare($query)
            ->bind(':id', $id);

        $this->connectionFactory->execute();
        return $this->hydrateEmployee()[0];
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        $query = "
            SELECT * FROM person AS p 
            INNER JOIN employee AS e ON p.id = e.id;
        ";
        $this->connectionFactory->query($query);
        return $this->hydrateEmployee();
    }

    /**
     * @return array
     */
    private function hydrateEmployee(): array
    {
        $employeeList = [];
        $data = $this->connectionFactory->getAll();
        foreach ($data as $item) {
            $employeeList[] = new Employee(
                (int) $item['id'],
                (string) $item['cpf'],
                (string) $item['name'],
                (string) $item['last_name'],
                (string) $item['office'],
                (float) $item['wage']
            );
        }
        return $employeeList;
    }

    /**
     * @param Employee $employee
     * @return int|null
     */
    public function save(Employee $employee): ?int
    {
        $this->connectionFactory->beginTransaction();

        $isPrincipalCreated = false;

        $query = "INSERT INTO person (cpf, name, last_name) VALUES (:cpf, :name, :last_name);";
        $this->connectionFactory->prepare($query)
            ->bind(':cpf', $employee->getCpf())
            ->bind(':name', $employee->getName())
            ->bind(':last_name', $employee->getLastName());

        $isPersonCreated = $this->connectionFactory->execute();

        $idPersonId = $this->connectionFactory->getLastInsertedId();

        if($isPersonCreated) {
            $query = "INSERT INTO employee (id, office, wage) VALUES (:id, :office, :wage)";
            $this->connectionFactory->prepare($query)
                ->bind(':id', $idPersonId)
                ->bind(':office', $employee->getOffice())
                ->bind(':wage', $employee->getWage());

            $isPrincipalCreated = $this->connectionFactory->execute();
        }

        if($isPrincipalCreated) {
            $this->connectionFactory->commit();
            return $idPersonId;
        }

        $this->connectionFactory->rollBack();
        return null;
    }

    /**
     * @param Employee $employee
     * @return bool
     */
    public function remove(Employee $employee): bool
    {
        $query = "DELETE FROM person WHERE id = :id";
        $this->connectionFactory->prepare($query)
            ->bind(':id', $employee->getId());

        return $this->connectionFactory->execute();
    }
}
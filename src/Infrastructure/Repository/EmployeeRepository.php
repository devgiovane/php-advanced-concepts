<?php


namespace Study\Infrastructure\Repository;


use Study\Domain\Entities\Employee;
use Study\Infrastructure\Persistence\ConnectionFactory;
use Study\Domain\Repository\EmployeeRepository as EmployeeRepositoryInterface;
/**
 * Class EmployeeRepository
 * @package Study\Infrastructure\Repository
 */
class EmployeeRepository implements EmployeeRepositoryInterface
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
                (float) $item['wage'],
                (string) $item['type']
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
        $query = "INSERT INTO person (cpf, name, last_name, type) VALUES (:cpf, :name, :last_name, :type);";
        $this->connectionFactory->prepare($query)
            ->bind(':cpf', $employee->getCpf())
            ->bind(':name', $employee->getName())
            ->bind(':last_name', $employee->getLastName())
            ->bind(':type', $employee->getType());
        $isPersonCreated = $this->connectionFactory->execute();
        if (!$isPersonCreated) {
            $this->connectionFactory->rollBack();
            return null;
        }
        $idPersonId = $this->connectionFactory->getLastInsertedId();
        $query = "INSERT INTO employee (id, office, wage) VALUES (:id, :office, :wage)";
        $this->connectionFactory->prepare($query)
            ->bind(':id', $idPersonId)
            ->bind(':office', $employee->getOffice())
            ->bind(':wage', $employee->getWage());
        $isPrincipalCreated = $this->connectionFactory->execute();
        if (!$isPrincipalCreated) {
            $this->connectionFactory->rollBack();
            return null;
        }
        $this->connectionFactory->commit();
        return $idPersonId;
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
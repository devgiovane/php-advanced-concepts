<?php


namespace Study\Migration;


use Study\Domain\Infrastructure\Persistence\ConnectionFactory;
/**
 * Class EmployeeMigration
 * @package Study\Migration
 */
class EmployeeMigration extends Migration implements MigrationInterface
{
    /**
     * @var ConnectionFactory
     */
    private $connectionFactory;

    /**
     * Person constructor.
     */
    public function __construct()
    {
        $this->connectionFactory = new ConnectionFactory();
        $this->connectionFactory->create();
        parent::__construct($this->connectionFactory);
    }

    /**
     *
     */
    public function up(): void
    {
        $this->connectionFactory->prepare("CREATE TABLE IF NOT EXISTS employee (id INTEGER PRIMARY KEY NOT NULL, office TEXT, wage FLOAT, FOREIGN KEY(id) REFERENCES person(id) ON DELETE CASCADE);");
        echo "up " . __CLASS__ . ' ' . ($this->connectionFactory->execute() ? 'success' : 'error') . PHP_EOL;
    }

    /**
     *
     */
    public function down(): void
    {
        $this->beforeDown();
        $this->connectionFactory->prepare("DROP TABLE IF EXISTS employee;");
        echo "down " . __CLASS__ . ' ' . ($this->connectionFactory->execute() ? 'success' : 'error') . PHP_EOL;
    }

}
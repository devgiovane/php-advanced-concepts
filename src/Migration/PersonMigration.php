<?php


namespace Study\Migration;


use Study\Infrastructure\Persistence\ConnectionFactory;
/**
 * Class Person
 * @package Study\Migration
 */
final class PersonMigration extends Migration implements MigrationInterface
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
        $query = "
            CREATE TABLE IF NOT EXISTS person (
                id INTEGER PRIMARY KEY AUTOINCREMENT, 
                cpf TEXT NOT NULL,
                name TEXT NOT NULL, 
                last_name TEXT NOT NULL,
                type TEXT NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );
        ";
        $this->connectionFactory->prepare($query);
        echo "up " . __CLASS__ . ' ' . ($this->connectionFactory->execute() ? 'success' : 'error') . PHP_EOL;
    }

    /**
     *
     */
    public function down(): void
    {
        $this->beforeDown();
        $this->connectionFactory->prepare("DROP TABLE IF EXISTS person;");
        echo "down " . __CLASS__ . ' ' . ($this->connectionFactory->execute() ? 'success' : 'error') . PHP_EOL;
    }

}
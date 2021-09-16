<?php


namespace Study\Migration;


use Study\Domain\Infrastructure\Persistence\ConnectionFactory;
/**
 * Class AccountSavingMigration
 * @package Study\Migration
 */
class AccountSavingMigration extends Migration implements MigrationInterface
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
        $this->connectionFactory->prepare("CREATE TABLE IF NOT EXISTS account_saving (id INTEGER PRIMARY KEY NOT NULL, FOREIGN KEY(id) REFERENCES account(id) ON DELETE CASCADE);");
        echo "up " . __CLASS__ . ' ' . ($this->connectionFactory->execute() ? 'success' : 'error') . PHP_EOL;
    }

    /**
     *
     */
    public function down(): void
    {
        $this->beforeDown();
        $this->connectionFactory->prepare("DROP TABLE IF EXISTS account_saving;");
        echo "down " . __CLASS__ . ' ' . ($this->connectionFactory->execute() ? 'success' : 'error') . PHP_EOL;
    }

}
<?php

namespace Refaktor\Blog\EntityGateway\PDOMySQL;

use PDO;
use Refaktor\Blog\EntityGateway\VersionedEntityGateway;

abstract class EntityGateway implements VersionedEntityGateway {
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @return string[]
     */
    abstract protected function getMigrationVersions();

    /**
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @return PDO
     */
    protected function getConnection() {
        return $this->pdo;
    }

    /**
     * @return void
     */
    public function upgradeDatabase() {
        $connection = $this->getConnection();
        $connection->query(/** @lang MySQL */
            '
			CREATE TABLE IF NOT EXISTS migrations (
				id BIGINT PRIMARY KEY AUTO_INCREMENT NOT NULL,
				class_name VARCHAR(255),
				
				UNIQUE u_class_name (class_name)
			) ENGINE=InnoDB;
			');

        $executedMigrations = $connection->query(/** @lang MySQL */
            'SELECT class_name FROM migrations')->fetchAll();
        $dueMigrations      = $this->getMigrationVersions();

        foreach ($executedMigrations as $row) {
            if (in_array($row['class_name'], $dueMigrations)) {
                unset($dueMigrations[array_search($row['class_name'], $dueMigrations)]);
            }
        }

        foreach ($dueMigrations as $dueMigration) {
            /**
             * @var Migration $migrationClass
             */
            $migrationClass = new $dueMigration($connection);
            $migrationClass->upgrade();
            $connection
                ->prepare('INSERT INTO migrations (class_name) VALUES (?)')
                ->execute([$dueMigration]);
        }
    }
}
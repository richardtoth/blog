<?php


namespace Refaktor\Blog\EntityGateway\PDOMySQL\Migrations;

use PDO;

abstract class Migration {
    /**
     * @var PDO
     */
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    abstract function upgrade();

    /**
     * @return PDO
     */
    protected function getPDO() {
        return $this->pdo;
    }
}
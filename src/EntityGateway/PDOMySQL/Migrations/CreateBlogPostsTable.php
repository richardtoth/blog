<?php


namespace Refaktor\Blog\EntityGateway\PDOMySQL\Migrations;

class CreateBlogPostsTable extends Migration {

    function upgrade() {
        $this->getPDO()->query(/** @lang MySQL */
            '
            CREATE TABLE IF NOT EXISTS blogposts (
                slug VARCHAR(255) PRIMARY KEY,
                author VARCHAR(255) NOT NULL,
                title VARCHAR(255) NOT NULL,
                content MEDIUMTEXT NOT NULL,
                published_at DATETIME NOT NULL
            ) ENGINE=InnoDB;
            ');
    }
}
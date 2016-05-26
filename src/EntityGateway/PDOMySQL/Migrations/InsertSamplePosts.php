<?php


namespace Refaktor\Blog\EntityGateway\PDOMySQL\Migrations;

class InsertSamplePosts extends Migration {

    function upgrade() {
        $data = [
            ['hello-world', 'Janos', 'Hello world!', 'This is my first blog post!', '2016-05-25 00:00:00'],
            ['second-post', 'Janos', 'This is my second post', 'I\'m now blogging!', '2016-05-26 00:00:00'],
        ];

        $statement = $this->getPDO()->prepare('
            INSERT INTO blogposts
            (slug, author, title, content, published_at) VALUES (?,?,?,?,?)
        ');
        foreach ($data as $row) {
            $statement->execute($row);
        }
    }
}
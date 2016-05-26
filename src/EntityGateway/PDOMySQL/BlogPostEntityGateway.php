<?php

namespace Refaktor\Blog\EntityGateway\PDOMySQL;

use Refaktor\Blog\BlogAuthorEntity;
use Refaktor\Blog\BlogPostBySlugGateway;
use Refaktor\Blog\BlogPostEntity;
use Refaktor\Blog\BlogPostLatestPostsGateway;
use Refaktor\Blog\EntityGateway\PDOMySQL\Migrations\CreateBlogPostsTable;
use Refaktor\Blog\EntityGateway\PDOMySQL\Migrations\InsertSamplePosts;
use Refaktor\Blog\EntityNotFoundException;

class BlogPostEntityGateway extends EntityGateway implements BlogPostBySlugGateway, BlogPostLatestPostsGateway {
    /**
     * @return string[]
     */
    protected function getMigrationVersions() {
        return [
            CreateBlogPostsTable::class,
            InsertSamplePosts::class
        ];
    }

    /**
     * @param array $row
     *
     * @return BlogPostEntity
     */
    private function rowToEntity($row) {
        $author = new BlogAuthorEntity();
        $author->setName($row['author']);

        $entity = new BlogPostEntity();
        $entity->setSlug($row['slug']);
        $entity->setTitle($row['title']);
        $entity->setPublishedAt(new \DateTime($row['published_at']));
        $entity->setContent($row['content']);
        $entity->setAuthor($author);

        return $entity;
    }

    /**
     * @param string $slug
     *
     * @return BlogPostEntity
     *
     * @throws EntityNotFoundException
     */
    public function getBySlug($slug) {
        $statement = $this->getConnection()->prepare(/** @lang MySQL */
            '
            SELECT
              slug,
              author,
              title,
              content,
              published_at
            FROM
              blogposts
            WHERE
              slug=?
        ');

        $statement->execute([$slug]);
        $result = $statement->fetchAll();

        if (!count($result)) {
            throw new EntityNotFoundException();
        }

        return $this->rowToEntity($result[0]);
    }

    /**
     * @param null|int $limit
     * @param null|int $offset
     *
     * @return BlogPostEntity[]
     */
    public function getOrderedByDate($limit = null, $offset = null) {
        $sql = /** @lang MySQL */
            '
            SELECT
              slug,
              author,
              title,
              content,
              published_at
            FROM
              blogposts
            ORDER BY
              published_at DESC
        ';
        if (!is_null($offset) && !is_null($limit)) {
            $sql .= 'LIMIT ' . (int)$limit . ' OFFSET ' . (int)$offset;
        } else if (!is_null($limit)) {
            $sql .= 'LIMIT ' . (int)$limit;
        }
        $statement = $this->getConnection()->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();

        $entities = [];
        foreach ($result as $row) {
            $entities[] = $this->rowToEntity($row);
        }
        return $entities;
    }
}
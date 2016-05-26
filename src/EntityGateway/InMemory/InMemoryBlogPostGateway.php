<?php

namespace Refaktor\Blog\EntityGateway\InMemory;

use Refaktor\Blog\BlogPostBySlugGateway;
use Refaktor\Blog\BlogPostEntity;
use Refaktor\Blog\BlogPostLatestPostsGateway;
use Refaktor\Blog\EntityNotFoundException;

class InMemoryBlogPostGateway implements BlogPostBySlugGateway, BlogPostLatestPostsGateway {

    /**
     * @var array|BlogPostEntity[]
     */
    private $blogPosts = array();

    /**
     * @param BlogPostEntity[] $blogPosts
     */
    public function __construct($blogPosts) {
        $this->blogPosts = $blogPosts;
    }

    /**
     * @param string $slug
     *
     * @return BlogPostEntity
     *
     * @throws EntityNotFoundException
     */
    public function getBySlug($slug) {
        foreach ($this->blogPosts as $blogPost) {
            if ($blogPost->getSlug() == $slug) {
                return $blogPost;
            }
        }
        throw new EntityNotFoundException('BlogPostEntity with slug \'' . $slug . '\' not found!');
    }

    /**
     * @param null|int $limit
     * @param null|int $offset
     *
     * @return BlogPostEntity[]
     */
    public function getOrderedByDate($limit = null, $offset = null) {
        $blogPosts = $this->blogPosts;

        usort($blogPosts,
            function ($firstPost, $secondPost) {
                /**
                 * @var BlogPostEntity $firstPost
                 * @var BlogPostEntity $secondPost
                 */
                if ($firstPost->getPublishedAt()->getTimestamp() > $secondPost->getPublishedAt()->getTimestamp()) {
                    return -1;
                } else {
                    if ($firstPost->getPublishedAt()->getTimestamp() < $secondPost->getPublishedAt()->getTimestamp()) {
                        return 1;
                    } else {
                        return 0;
                    }
                }
            });

        if ($offset === null) {
            $offset = 0;
        }
        $blogPosts = \array_slice($blogPosts, $offset, $limit);

        return $blogPosts;
    }
}
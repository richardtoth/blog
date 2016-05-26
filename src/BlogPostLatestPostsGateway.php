<?php


namespace Refaktor\Blog;

/**
 * This interface declares the functions required to fetch a BlogPost entity ordered by date.
 */
interface BlogPostLatestPostsGateway {
    /**
     * @param null|int $limit
     * @param null|int $offset
     *
     * @return BlogPostEntity[]
     */
    public function getOrderedByDate($limit = null, $offset = null);
}
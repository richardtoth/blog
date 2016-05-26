<?php

namespace Refaktor\Blog;

/**
 * This interface declares the function required for getting the blog post listings.
 */
interface BlogPostLatestPostsBoundary {
    /**
     * @param null|int $limit
     * @param null|int $offset
     *
     * @return BlogPostLatestPostsResponse
     */
    public function getLatestPosts($limit = null, $offset = null);
}
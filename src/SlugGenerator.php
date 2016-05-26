<?php

namespace Refaktor\Blog;

/**
 * Declares the functions needed to generate a slug from a blog post title.
 */
interface SlugGenerator {
    /**
     * @param string $title
     *
     * @return string
     */
    public function generateSlug($title);
}
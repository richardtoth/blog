<?php

namespace Refaktor\Blog;

/**
 * This object represents a BlogPost for interaction with a boundary. It is closely connected to the BlogPost entity.
 *
 * @see BlogPost
 */
class BlogPostResponseObject {

    /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * @var BlogAuthorEntity
     */
    private $author;

    /**
     * @var \DateTime
     */
    private $publishedAt;

    /**
     * @return string
     */
    public function getSlug() {
        return $this->slug;
    }

    /**
     * @param string $slug
     *
     * @return $this
     */
    public function setSlug($slug) {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Returns the title of the blogpost.
     *
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set the title of the blogpost. If the slug is not set, it automatically generates a slug
     *
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title) {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return $this
     */
    public function setContent($content) {
        $this->content = $content;

        return $this;
    }

    /**
     * @return BlogAuthorResponseObject
     */
    public function getAuthor() {
        return $this->author;
    }

    /**
     * @param BlogAuthorResponseObject $author
     *
     * @return $this
     */
    public function setAuthor(BlogAuthorResponseObject $author) {
        $this->author = $author;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPublishedAt() {
        return $this->publishedAt;
    }

    /**
     * @param \DateTime $publishedAt
     *
     * @return $this
     */
    public function setPublishedAt($publishedAt) {
        $this->publishedAt = $publishedAt;

        return $this;
    }
}
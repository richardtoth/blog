<?php

namespace Refaktor\Blog;

/**
 * A person authoring a BlogPost
 */
class BlogAuthor {
    /**
     * @var string
     */
    private $name;

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }
}
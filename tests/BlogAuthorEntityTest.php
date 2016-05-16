<?php

namespace Refaktor\Blog;

/**
 * @covers Refaktor\Blog\BlogAuthorEntity
 */
class BlogAuthorEntityTest extends \PHPUnit_Framework_TestCase {

    /**
     * @covers Refaktor\Blog\BlogAuthorEntity::setName
     * @covers Refaktor\Blog\BlogAuthorEntity::getName
     */
    public function testSetGetName() {
        //setup
        $blogAuthor = new BlogAuthorEntity();
        //assert
        $this->assertInstanceOf('Refaktor\\Blog\\BlogAuthorEntity', $blogAuthor->setName('John Doe'));
        $this->assertEquals('John Doe', $blogAuthor->getName());
    }
}
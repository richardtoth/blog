<?php

namespace Refaktor\Blog;

/**
 * @covers Refaktor\Blog\BlogAuthor
 */
class BlogAuthorTest extends \PHPUnit_Framework_TestCase {

    /**
     * @covers Refaktor\Blog\BlogAuthor::setName
     * @covers Refaktor\Blog\BlogAuthor::getName
     */
    public function testSetGetName() {
        //setup
        $blogAuthor = new BlogAuthor();
        //assert
        $this->assertInstanceOf('Refaktor\\Blog\\BlogAuthor', $blogAuthor->setName('John Doe'));
        $this->assertEquals('John Doe', $blogAuthor->getName());
    }
}
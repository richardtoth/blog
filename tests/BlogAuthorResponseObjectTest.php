<?php

namespace Refaktor\Blog;

/**
 * @covers Refaktor\Blog\BlogAuthorResponseObject
 */
class BlogAuthorResponseObjectTest extends \PHPUnit_Framework_TestCase {

    /**
     * @covers Refaktor\Blog\BlogAuthorResponseObject::setName
     * @covers Refaktor\Blog\BlogAuthorResponseObject::getName
     */
    public function testSetGetName() {
        //setup
        $blogAuthor = new BlogAuthorResponseObject();
        //assert
        $this->assertInstanceOf('Refaktor\\Blog\\BlogAuthorResponseObject', $blogAuthor->setName('John Doe'));
        $this->assertEquals('John Doe', $blogAuthor->getName());
    }
}
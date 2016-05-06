<?php

namespace Refaktor\Blog;

/**
 * @covers Refaktor\Blog\BlogPost
 */
class BlogPostTest extends \PHPUnit_Framework_TestCase {

    /**
     * @covers Refaktor\Blog\BlogPost::setSlug
     * @covers Refaktor\Blog\BlogPost::getSlug
     */
    public function testSetGetSlug() {
        //setup
        $blogPost = new BlogPost();
        //assert
        $this->assertInstanceOf('Refaktor\\Blog\\BlogPost', $blogPost->setSlug('test'));
        $this->assertEquals('test', $blogPost->getSlug());
    }

    /**
     * @covers Refaktor\Blog\BlogPost::setTitle
     * @covers Refaktor\Blog\BlogPost::getTitle
     */
    public function testSetGetTitle() {
        //setup
        $blogPost = new BlogPost();
        //assert
        $this->assertInstanceOf('Refaktor\\Blog\\BlogPost', $blogPost->setTitle('test'));
        $this->assertEquals('test', $blogPost->getTitle());
    }

    /**
     * @covers Refaktor\Blog\BlogPost::setContent
     * @covers Refaktor\Blog\BlogPost::getContent
     */
    public function testSetGetContent() {
        //setup
        $blogPost = new BlogPost();
        //assert
        $this->assertInstanceOf('Refaktor\\Blog\\BlogPost', $blogPost->setContent('test content'));
        $this->assertEquals('test content', $blogPost->getContent());
    }

    /**
     * @covers Refaktor\Blog\BlogPost::setTitle
     */
    public function setCreateSlug() {
        //setup
        $blogPost = new BlogPost();
        //act
        $blogPost->setTitle('This is my test blog post');
        //assert
        $this->assertEquals('this-is-my-test-blog-post', $blogPost->getSlug());
    }
}
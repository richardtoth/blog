<?php

namespace Refaktor\Blog;

/**
 * @covers Refaktor\Blog\BlogPostBySlugResponse
 */
class BlogPostBySlugResponseTest extends \PHPUnit_Framework_TestCase {
    /**
     * @covers Refaktor\Blog\BlogPostBySlugResponse::__construct
     * @covers Refaktor\Blog\BlogPostBySlugResponse::getBlogPost
     */
    public function testConstructGetBlogPost() {
        //setup
        $blogPost = new BlogPostResponseObject();
        $response = new BlogPostBySlugResponse($blogPost);
        //act
        //assert
        $this->assertEquals($blogPost, $response->getBlogPost());
    }

    /**
     * @covers Refaktor\Blog\BlogPostBySlugResponse::setBlogPost
     * @covers Refaktor\Blog\BlogPostBySlugResponse::getBlogPost
     */
    public function testSetGetBlogPost() {
        //setup
        $blogPost1 = new BlogPostResponseObject();
        $blogPost2 = new BlogPostResponseObject();
        $response  = new BlogPostBySlugResponse($blogPost1);
        //act
        
        //assert
        $this->assertEquals($response, $response->setBlogPost($blogPost2));
        $this->assertFalse($blogPost1 === $response->getBlogPost());
        $this->assertTrue($blogPost2 === $response->getBlogPost());
    }
}
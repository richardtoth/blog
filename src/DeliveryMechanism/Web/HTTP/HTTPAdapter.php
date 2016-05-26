<?php

namespace Refaktor\Blog\DeliveryMechanism\Web\HTTP;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;

/**
 * This interface provides standardized access to the PSR-7 nightmare.
 */
interface HTTPAdapter {
    /**
     * @param array $server
     * @param array $get
     * @param array $post
     * @param array $cookie
     * @param array $files
     */
    public function __construct(array $server, array $get, array $post, array $cookie, array $files);

    /**
     * Returns the HTTP request.
     *
     * @return ServerRequestInterface
     */
    public function getRequest();

    /**
     * Returns the response being sent.
     *
     * @return ResponseInterface
     */
    public function getResponse();

    /**
     * Override the response being sent out.
     *
     * @param ResponseInterface $response
     */
    public function overrideResponse(ResponseInterface $response);

    /**
     * Create a stream for a response from a string.
     *
     * @param string $string
     *
     * @return StreamInterface
     */
    public function getStringStream($string);
}
<?php

namespace Refaktor\Blog\DeliveryMechanism\Web\HTTP;

use GuzzleHttp\Psr7\LazyOpenStream;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;

class GuzzleHTTPAdapter implements HTTPAdapter {
    private $request;
    private $response;

    /**
     * @param array $server
     * @param array $get
     * @param array $post
     * @param array $cookie
     * @param array $files
     */
    public function __construct(array $server, array $get, array $post, array $cookie, array $files) {
        $method  = $this->getMethod($server);
        $headers = [];
        $uri = $this->getUri($server);
        //todo find a method to abstract the input stream without having to expose guzzle for POST requests.
        $body          = new LazyOpenStream('php://input', 'r+');
        $protocol      = $this->getProtocol($server);
        $serverRequest = new ServerRequest($method, $uri, $headers, $body, $protocol, $server);
        $this->request = $serverRequest
            ->withCookieParams($cookie)
            ->withQueryParams($get)
            ->withParsedBody($post);
        $this->response = new Response();
    }

    private function getMethod($server) {
        return isset($server['REQUEST_METHOD']) ? $server['REQUEST_METHOD'] : 'GET';
    }

    private function getUri($server) {
        $uri     = new Uri('');
        if (isset($server['HTTPS'])) {
            $uri = $uri->withScheme($server['HTTPS'] == 'on' ? 'https' : 'http');
        } else {
            $uri = $uri->withScheme('http');
        }
        $server['HTTP_HOST'] = preg_replace('/:[0-9]+$/', '', $server['HTTP_HOST']);
        if (isset($server['HTTP_HOST'])) {
            $uri = $uri->withHost($server['HTTP_HOST']);
        } elseif (isset($server['SERVER_NAME'])) {
            $uri = $uri->withHost($server['SERVER_NAME']);
        }
        if (isset($server['SERVER_PORT'])) {
            $uri = $uri->withPort($server['SERVER_PORT']);
        }
        if (isset($server['REQUEST_URI'])) {
            $uri = $uri->withPath(current(explode('?', $server['REQUEST_URI'])));
        }
        if (isset($server['QUERY_STRING'])) {
            $uri = $uri->withQuery($server['QUERY_STRING']);
        }

        return $uri;
    }

    private function getProtocol($server) {
        return isset($server['SERVER_PROTOCOL']) ? str_replace('HTTP/', '', $server['SERVER_PROTOCOL']) : '1.1';
    }

    /**
     * Returns the HTTP request.
     *
     * @return ServerRequestInterface
     */
    public function getRequest() {
        return $this->request;
    }

    /**
     * Returns the response being sent.
     *
     * @return ResponseInterface
     */
    public function getResponse() {
        return $this->response;
    }

    /**
     * Override the response being sent out.
     *
     * @param ResponseInterface $response
     */
    public function overrideResponse(ResponseInterface $response) {
        $this->response = $response;
    }

    /**
     * Create a stream for a response from a string.
     *
     * @param string $string
     *
     * @return StreamInterface
     */
    public function getStringStream($string) {
        return \GuzzleHttp\Psr7\stream_for($string);
    }
}
<?php

use PHPUnit\Framework\TestCase;
use Slim\Factory\AppFactory;
use Slim\Psr7\Factory\RequestFactory;
use Slim\Psr7\Factory\ResponseFactory;
use Slim\Psr7\Environment;

require_once 'vendor/autoload.php';

class TodoTest extends TestCase
{
    private $app;

    protected function setUp(): void
    {
        $this->app = AppFactory::create();
        require_once 'routes/todo.php';
    }

    public function testGetTodos()
    {
        $env = Environment::mock([
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/todos',
            'CONTENT_TYPE' => 'application/json'
        ]);

        $requestFactory = new RequestFactory();
        $responseFactory = new ResponseFactory();

        $request = $requestFactory->createRequest($env);
        $response = $responseFactory->createResponse();

        $response = $this->app->handle($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertContains('application/json', $response->getHeaderLine('Content-Type'));
    }

    public function testGetTodo()
    {
        $env = Environment::mock([
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/todo/1',
            'CONTENT_TYPE' => 'application/json'
        ]);

        $requestFactory = new RequestFactory();
        $responseFactory = new ResponseFactory();

        $request = $requestFactory->createRequest($env);
        $response = $responseFactory->createResponse();

        $response = $this->app->handle($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertContains('application/json', $response->getHeaderLine('Content-Type'));
    }

    public function testPostTodo()
    {
        $env = Environment::mock([
            'REQUEST_METHOD' => 'POST',
            'REQUEST_URI' => '/todo',
            'CONTENT_TYPE' => 'application/json'
        ]);

        $requestFactory = new RequestFactory();
        $responseFactory = new ResponseFactory();

        $request = $requestFactory->createRequest($env);
        $request = $request->withParsedBody([
            'name' => 'Test Todo',
            'comment' => 'Test Comment',
            'status' => 'todo'
        ]);

        $response = $responseFactory->createResponse();

        $response = $this->app->handle($request);

        $this->assertSame(201, $response->getStatusCode());
        $this->assertContains('application/json', $response->getHeaderLine('Content-Type'));
    }

    public function testDeleteTodo()
    {
        $env = Environment::mock([
            'REQUEST_METHOD' => 'DELETE',
            'REQUEST_URI' => '/todo/1',
            'CONTENT_TYPE' => 'application/json'
        ]);

        $requestFactory = new RequestFactory();
        $responseFactory = new ResponseFactory();

        $request = $requestFactory->createRequest($env);
        $response = $responseFactory->createResponse();

        $response = $this->app->handle($request);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertContains('application/json', $response->getHeaderLine('Content-Type'));
    }
}

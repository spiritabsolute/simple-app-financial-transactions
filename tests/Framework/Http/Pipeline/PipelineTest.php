<?php
namespace Tests\Framework\Http\Pipeline;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\ServerRequest;
use Framework\Http\Pipeline\Pipeline;

class PipelineTest extends TestCase
{
	public function testPipe()
	{
		$pipeline = new Pipeline();

		$pipeline->pipe(new Middleware1());
		$pipeline->pipe(new Middleware2());

		$response = $pipeline(new ServerRequest(), new Response(), new Last());

		$this->assertJsonStringEqualsJsonString(
			json_encode(["middleware-1" => 1, "middleware-2" => 2]),
			$response->getBody()->getContents()
		);
	}
}

class Middleware1
{
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
	{
		return $next($request->withAttribute("middleware-1", 1));
	}
}

class Middleware2
{
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
	{
		return $next($request->withAttribute("middleware-2", 2));
	}
}

class Last
{
	public function __invoke(ServerRequestInterface $request)
	{
		return new JsonResponse($request->getAttributes());
	}
}
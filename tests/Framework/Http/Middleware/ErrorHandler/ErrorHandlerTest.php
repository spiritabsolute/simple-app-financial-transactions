<?php
namespace Tests\Framework\Http\Middleware\ErrorHandler;

use Framework\Http\Middleware\ErrorHandler\ErrorHandler;
use Framework\Http\Middleware\ErrorHandler\ErrorResponseGenerator;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\ServerRequest;

class ErrorHandlerTest extends TestCase
{
	/**
	 * @var ErrorHandler
	 */
	private $handler;

	protected function setUp()
	{
		parent::setUp();

		/**
		 * @var \PHPUnit_Framework_MockObject_MockObject|LoggerInterface $logger
		 */
		$logger = $this->createMock(LoggerInterface::class);
		$logger->method("error")->willReturn(null);

		$this->handler = new ErrorHandler(new DummyGenerator, $logger);
	}

	public function testNone(): void
	{
		$response = $this->handler->process(new ServerRequest(), new CorrectAction());

		self::assertEquals("Content", $response->getBody()->getContents());
		self::assertEquals(200, $response->getStatusCode());
	}

	public function testException(): void
	{
		$response = $this->handler->process(new ServerRequest(), new ErrorAction());

		self::assertEquals("Runtime Error", $response->getBody()->getContents());
		self::assertEquals(500, $response->getStatusCode());
	}
}

class DummyGenerator implements ErrorResponseGenerator
{
	public function generate(ServerRequestInterface $request, \Throwable $e): ResponseInterface
	{
		return new HtmlResponse($e->getMessage(), 500);
	}
}

class CorrectAction implements RequestHandlerInterface
{
	public function handle(ServerRequestInterface $request): ResponseInterface
	{
		return new HtmlResponse("Content");
	}
}

class ErrorAction implements RequestHandlerInterface
{
	public function handle(ServerRequestInterface $request): ResponseInterface
	{
		throw new \RuntimeException("Runtime Error");
	}
}
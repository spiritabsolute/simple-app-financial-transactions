<?php
namespace App\Http\Middleware;

use Framework\Template\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;

class PageNotFound implements RequestHandlerInterface
{
	/**
	 * @var TemplateRenderer
	 */
	private $templateRenderer;

	public function __construct(TemplateRenderer $templateRenderer)
	{
		$this->templateRenderer = $templateRenderer;
	}

	/**
	 * Handles a request and produces a response.
	 *
	 * May call other collaborating code to generate the response.
	 *
	 * @param ServerRequestInterface $request
	 *
	 * @return ResponseInterface
	 */
	public function handle(ServerRequestInterface $request): ResponseInterface
	{
		return new HtmlResponse($this->templateRenderer->render('error/404', [
			'request' => $request,
		]), 404);
	}
}

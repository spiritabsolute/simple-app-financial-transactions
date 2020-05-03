<?php
namespace App\Http\Action;

use Framework\Template\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;

class Home implements RequestHandlerInterface
{
	private $templateRenderer;

	public function __construct(TemplateRenderer $templateRenderer)
	{
		$this->templateRenderer = $templateRenderer;
	}

	public function handle(ServerRequestInterface $request): ResponseInterface
	{
		return new HtmlResponse($this->templateRenderer->render('app/home'));
	}
}
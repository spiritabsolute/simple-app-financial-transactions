<?php
namespace App\Http\Action;

use App\Entity\User;
use App\Http\Middleware\BasicAuth;
use App\Service\AccountService;
use Framework\Template\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Diactoros\Response\HtmlResponse;

class Cabinet implements RequestHandlerInterface
{
	private $templateRenderer;
	private $accountService;

	public function __construct(TemplateRenderer $templateRenderer, AccountService $accountService)
	{
		$this->templateRenderer = $templateRenderer;
		$this->accountService = $accountService;
	}

	public function handle(ServerRequestInterface $request): ResponseInterface
	{
		$username = $request->getAttribute(BasicAuth::ATTRIBUTE);

		$user = new User($username);

		return new HtmlResponse($this->templateRenderer->render('app/cabinet', [
			'user' => $user,
			'balance' => $this->accountService->getAccountBalance($user)
		]));
	}
}
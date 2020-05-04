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

class Deposit implements RequestHandlerInterface
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

		$errors = [];

		if ($request->getMethod() == 'POST')
		{
			$post = $request->getParsedBody();

			$amount = (int) $post['deposit_amount'];
			$paymentMethod = (string) $post['payment_method'];

			$deposit = new \App\Entity\Deposit($amount, $paymentMethod);
			$errors = $deposit->getErrors();
			if (!$errors)
			{
				$this->accountService->depositAccountBalance($user, $deposit);
			}
		}

		return new HtmlResponse($this->templateRenderer->render('app/deposit', [
			'user' => $user,
			'balance' => $this->accountService->getAccountBalance($user),
			'errors' => $errors
		]));
	}
}
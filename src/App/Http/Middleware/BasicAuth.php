<?php
namespace App\Http\Middleware;

use App\Service\UserService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BasicAuth
{
	public const ATTRIBUTE = "username";

	private $userService;

	public function __construct(UserService $userService)
	{
		$this->userService = $userService;
	}

	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
	{
		$username = $request->getServerParams()["PHP_AUTH_USER"] ?? null;
		$password = $request->getServerParams()["PHP_AUTH_PW"] ?? null;

		if (!empty($username) && !empty($password))
		{
			$userData = $this->userService->findByUsername($username);
			if (password_verify($password, $userData['password_hash']))
			{
				return $next($request->withAttribute(self::ATTRIBUTE, $userData['username']), $response);
			}
		}

		return $response->withStatus(401)->withHeader("WWW-Authenticate", "Basic realm=Restricted area");
	}
}
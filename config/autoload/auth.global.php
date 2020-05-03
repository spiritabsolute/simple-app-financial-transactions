<?php

use App\Http\Middleware\BasicAuth;
use App\Service\UserService;
use Psr\Container\ContainerInterface;

return [
	"dependencies" => [
		"factories" => [
			BasicAuth::class => function (ContainerInterface $container) {
				return new BasicAuth($container->get(UserService::class));
			},
		]
	],
	"auth" => [
		"users" => []
	]
];
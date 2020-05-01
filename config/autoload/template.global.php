<?php

use Framework\Template\Php\Extension\Route;
use Framework\Template\Php\PhpRenderer;
use Framework\Template\TemplateRenderer;
use Psr\Container\ContainerInterface;

return [
	"templates" => [
		"dir" => "../templates",
		"extension" => [
			Route::class
		]
	],
	"dependencies" => [
		"factories" => [
			TemplateRenderer::class => function (ContainerInterface $container) {
				$config = $container->get("config")["templates"];
				$phpRenderer = new PhpRenderer($config["dir"]);
				foreach ($config["extension"] as $extension)
				{
					$phpRenderer->addExtension($container->get($extension));
				}
				return $phpRenderer;
			}
		]
	]
];
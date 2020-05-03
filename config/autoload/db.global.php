<?php
use Infrastructure\MySQLConnectionFactory;
use Infrastructure\MySQLAdapter;
use Psr\Container\ContainerInterface;

return [
	'dependencies' => [
		'factories' => [
			'db' => MySQLConnectionFactory::class,
			MySQLAdapter::class => function (ContainerInterface $container) {
				return new MySQLAdapter($container->get('db'));
			},
		]
	],
	'dbConfig' => [
		'host' => 'mysql',
		'username' => 'spirit',
		'password' => 'spirit',
		'database' => 'spirit',
		'port' => '3306'
	],
];
<?php

require __DIR__."/../vendor/autoload.php";

$container = require __DIR__."/../config/container.php";

$config = $container->get('config')['dbConfig'];

return [
	'environments' => [
		'default_migrations_table' => 'migrations',
		'default_database' => 'spirit',
		'app' => [
			'adapter' => 'mysql',
			'host' => $config['host'],
			'name' => $config['database'],
			'user' => $config['username'],
			'pass' => $config['password'],
			'port' => $config['port'],
			'connection' => $container->get('db'),
		],
	],
	'paths' => [
		'migrations' => 'data/mysql/migrations/',
		'seeds' => 'data/mysql/seeds/'
	]
];
<?php
use App\Http\Action;

/**
 * @var \Framework\Http\Application $app
 */

$app->get('home', '/', Action\Home::class);
$app->get('cabinet', '/cabinet', [
	$container->get(App\Http\Middleware\BasicAuth::class),
	Action\Cabinet::class
]);
$app->any('deposit', '/deposit', [
	$container->get(App\Http\Middleware\BasicAuth::class),
	Action\Deposit::class
]);
$app->any('withdraw', '/withdraw', [
	$container->get(App\Http\Middleware\BasicAuth::class),
	Action\Withdraw::class
]);
<?php
namespace App\Gateway;

interface Gateway
{
	public function fillParameters(array $params): void;
	public function sendRequest(): bool;
}
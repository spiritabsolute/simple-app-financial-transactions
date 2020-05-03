<?php
namespace App\Gateway;

class Card implements Gateway
{
	private $params;

	public function fillParameters(array $params): void
	{
		$this->params = $params;
	}

	public function sendRequest(): bool
	{
		return true;
	}
}
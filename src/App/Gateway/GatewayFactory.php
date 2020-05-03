<?php
namespace App\Gateway;

class GatewayFactory
{
	private $paymentMethod;

	public function __construct(string $paymentMethod)
	{
		$this->paymentMethod = $paymentMethod;
	}

	public function createGateway(): Gateway
	{
		switch ($this->paymentMethod)
		{
			case 'card':
				return new Card();
				break;
			default:
				return new Card();
		}
	}
}
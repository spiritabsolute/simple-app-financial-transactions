<?php
namespace App\Entity;

class Deposit
{
	private $amount;
	private $paymentMethod;

	private $availablePaymentMethod = [
		'card'
	];

	public function __construct(int $amount, string $paymentMethod)
	{
		if (!in_array($paymentMethod, $this->availablePaymentMethod))
		{
			throw new \Exception('An unavailable payment method');
		}

		if ($amount <= 0)
		{
			throw new \Exception('Incorrect deposit amount');
		}

		$this->amount = $amount;
		$this->paymentMethod = $paymentMethod;
	}

	public function getAmount(): int
	{
		return $this->amount;
	}

	public function getPaymentMethod(): string
	{
		return $this->paymentMethod;
	}
}
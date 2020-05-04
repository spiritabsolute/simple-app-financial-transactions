<?php
namespace App\Entity;

class Withdraw
{
	private $amount;
	private $paymentMethod;

	private $availablePaymentMethod = [
		'card'
	];

	private $errorCollection = [];

	const ERROR_INCORRECT_VALUE = 'ERROR_INCORRECT_VALUE';

	public function __construct(int $amount, string $paymentMethod)
	{
		if (!in_array($paymentMethod, $this->availablePaymentMethod))
		{
			$this->addError(self::ERROR_INCORRECT_VALUE, 'An unavailable payment method');
		}

		if ($amount <= 0)
		{
			$this->addError(self::ERROR_INCORRECT_VALUE, 'Incorrect withdraw amount');
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

	public function getErrors(): array
	{
		return $this->errorCollection;
	}

	private function addError(string $code, string $message): void
	{
		$this->errorCollection[$code] = $message;
	}
}
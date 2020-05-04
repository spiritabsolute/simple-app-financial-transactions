<?php
namespace App\Service;

use App\Entity\Deposit;
use App\Entity\User;
use App\Entity\Withdraw;
use App\Gateway\GatewayFactory;
use App\Storage\MySQL\AccountStorage;

class AccountService
{
	private $accountStorage;

	private $errorCollection = [];

	const ERROR_DEPOSIT = 'ERROR_DEPOSIT';
	const ERROR_WITHDRAW = 'ERROR_WITHDRAW';

	public function __construct(AccountStorage $accountStorage)
	{
		$this->accountStorage = $accountStorage;
	}

	public function getAccountBalance(User $user): int
	{
		return $this->accountStorage->getBalanceByUsername($user->getUsername());
	}

	public function depositAccountBalance(User $user, Deposit $deposit): void
	{
		$gatewayFactory = new GatewayFactory($deposit->getPaymentMethod());
		$paymentGateway = $gatewayFactory->createGateway();
		$paymentGateway->fillParameters([
			'amount' => $deposit->getAmount()
		]);
		$paymentResult = $paymentGateway->sendRequest();

		if ($paymentResult)
		{
			$this->accountStorage->increaseBalanceByUsername($user->getUsername(), $deposit->getAmount());
		}
	}

	public function withdrawAccountBalance(User $user, Withdraw $withdraw): void
	{
		$this->accountStorage->beginTransaction();

		$this->accountStorage->lockTable();

		$balance = $this->accountStorage->getBalanceByUsername($user->getUsername());
		if ($withdraw->getAmount() > $balance)
		{
			$this->addError(self::ERROR_WITHDRAW, 'Insufficient funds');
			return;
		}

		$gatewayFactory = new GatewayFactory($withdraw->getPaymentMethod());
		$paymentGateway = $gatewayFactory->createGateway();
		$paymentGateway->fillParameters([
			'amount' => $withdraw->getAmount()
		]);
		$paymentResult = $paymentGateway->sendRequest();

		if ($paymentResult)
		{
			$this->accountStorage->reduceBalanceByUsername($user->getUsername(), $withdraw->getAmount());

			$this->accountStorage->commitTransaction();

			$this->accountStorage->unlockTable();
		}
		else
		{
			$this->accountStorage->rollbackTransaction();
		}
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
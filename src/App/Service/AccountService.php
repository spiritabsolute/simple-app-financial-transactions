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

	public function __construct(AccountStorage $accountStorage)
	{
		$this->accountStorage = $accountStorage;
	}

	public function getAccountBalance(User $user): int
	{
		return $this->accountStorage->getBalanceByUsername($user->getUsername());
	}

	public function depositAccountBalance(User $user, Deposit $deposit)
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

	public function withdrawAccountBalance(User $user, Withdraw $withdraw)
	{
		$this->accountStorage->beginTransaction();

		$this->accountStorage->lockTable();

		$balance = $this->accountStorage->getBalanceByUsername($user->getUsername());
		if ($withdraw->getAmount() > $balance)
		{
			throw new \Exception('Incorrect withdraw amount');
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
}
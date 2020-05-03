<?php
namespace App\Service;

use App\Storage\MySQL\AccountStorage;

class AccountService
{
	private $accountStorage;

	public function __construct(AccountStorage $accountStorage)
	{
		$this->accountStorage = $accountStorage;
	}

	public function getAccountBalance(): int
	{
		return 0;
	}

	public function fillAccountBalance()
	{

	}

	public function withdrawAccountBalance()
	{

	}
}
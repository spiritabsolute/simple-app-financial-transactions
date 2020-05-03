<?php
namespace App\Service;

use App\Entity\User;
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
		return 0;
	}

	public function fillAccountBalance(User $user)
	{

	}

	public function withdrawAccountBalance(User $user)
	{

	}
}
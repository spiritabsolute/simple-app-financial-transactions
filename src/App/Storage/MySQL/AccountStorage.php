<?php
namespace App\Storage\MySQL;

class AccountStorage extends Storage
{
	public function addBalanceByUsername(string $username, int $amount): bool
	{
		$lastId = $this->storageAdapter->manipulateData(
			'UPDATE account SET balance=balance+? WHERE username=?',
			'ss',
			[$amount, $username]
		);

		return ($lastId >= 0);
	}

	public function getBalanceByUsername(string $username): int
	{
		$result = $this->storageAdapter->defineData(
			'SELECT balance FROM account WHERE username = ?',
			's',
			[$username]
		);
		return (int) $result[0]['balance'];
	}
}
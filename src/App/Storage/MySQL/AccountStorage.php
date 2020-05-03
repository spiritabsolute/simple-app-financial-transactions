<?php
namespace App\Storage\MySQL;

class AccountStorage extends Storage
{
	public function increaseBalanceByUsername(string $username, int $amount): bool
	{
		$lastId = $this->storageAdapter->manipulateData(
			'UPDATE account SET balance=balance+? WHERE username=?',
			'ss',
			[$amount, $username]
		);

		return ($lastId >= 0);
	}

	public function reduceBalanceByUsername(string $username, int $amount): bool
	{
		$lastId = $this->storageAdapter->manipulateData(
			'UPDATE account SET balance=balance-? WHERE username=?',
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

	public function lockTable(): void
	{
		$this->storageAdapter->query('LOCK TABLES account WRITE');
	}

	public function unlockTable(): void
	{
		$this->storageAdapter->query('UNLOCK TABLES');
	}

	public function beginTransaction(): void
	{
		$this->storageAdapter->query('START TRANSACTION');
	}

	public function commitTransaction(): void
	{
		$this->storageAdapter->query('COMMIT');
	}

	public function rollbackTransaction(): void
	{
		$this->storageAdapter->query('ROLLBACK');
	}
}
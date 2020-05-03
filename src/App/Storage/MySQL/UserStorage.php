<?php
namespace App\Storage\MySQL;

class UserStorage extends Storage
{
	public function findByUsername(string $username): array
	{
		return $this->storageAdapter->defineData(
			'SELECT * FROM user WHERE username = ?',
			's',
			[$username]
		);
	}
}
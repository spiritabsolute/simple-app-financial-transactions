<?php
namespace App\Service;

use App\Storage\MySQL\UserStorage;

class UserService
{
	private $userStorage;

	public function __construct(UserStorage $userStorage)
	{
		$this->userStorage = $userStorage;
	}

	public function findByUsername(string $username): array
	{
		return $this->userStorage->findByUsername($username)[0];
	}
}
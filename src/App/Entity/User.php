<?php
namespace App\Entity;

class User
{
	private $username;

	public function __construct(string $username)
	{
		$this->username = $username;
	}

	public function getUsername(): string
	{
		return $this->username;
	}
}
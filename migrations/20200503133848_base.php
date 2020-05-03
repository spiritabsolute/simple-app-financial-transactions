<?php

use Phinx\Migration\AbstractMigration;

class Base extends AbstractMigration
{
	public function change()
	{
		$user = $this->table('user', ['id' => false, 'primary_key' => ['username']]);
		$user->addColumn('username', 'string');
		$user->addColumn('password_hash', 'string');
		$user->create();

		$account = $this->table('account', ['id' => false, 'primary_key' => ['username']]);
		$account->addColumn('username', 'string');
		$account->addColumn('balance', 'integer', ['default' => 0]);
		$account->addForeignKey('username', 'user', 'username', ['delete'=> 'CASCADE']);
		$account->create();

		$user->insert([
			'username' => 'admin',
			'password_hash' => password_hash('test', PASSWORD_DEFAULT)
		]);
		$user->saveData();

		$account->insert([
			'username' => 'admin'
		]);
		$account->saveData();
	}
}

<?php
namespace App\Storage\MySQL;

use Infrastructure\MySQLAdapter;

class Storage
{
	protected $storageAdapter;

	public function __construct(MySQLAdapter $storageAdapter)
	{
		$this->storageAdapter = $storageAdapter;
	}
}
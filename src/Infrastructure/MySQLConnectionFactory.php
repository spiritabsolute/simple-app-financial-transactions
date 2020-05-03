<?php
namespace Infrastructure;

use Psr\Container\ContainerInterface;

class MySQLConnectionFactory
{
	private $connection;

	public function __invoke(ContainerInterface $container, $requestedName)
	{
		if ($this->connection == null)
		{
			$config = $container->get('config')['dbConfig'];

			$this->connection = mysqli_connect(
				$config['host'],
				$config['username'],
				$config['password'],
				$config['database'],
				$config['port']
			);
		}
		return $this->connection;
	}
}
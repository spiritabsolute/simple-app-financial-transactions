<?php
namespace Infrastructure;

class MySQLAdapter
{
	private $connection;

	public function __construct(\mysqli $connection)
	{
		$this->connection = $connection;
	}

	public function defineData($query, $paramType, array $paramValues): array
	{
		$sql = $this->connection->prepare($query);
		$this->bindQueryParams($sql, $paramType, $paramValues);

		$sql->execute();

		$mysqliResult = $sql->get_result();

		$result = [];

		if ($mysqliResult->num_rows > 0)
		{
			while ($row = $mysqliResult->fetch_assoc())
			{
				$result[] = $row;
			}
		}

		return $result;
	}

	public function manipulateData(string $query, $paramType, array $paramValues): int
	{
		$sql = $this->connection->prepare($query);
		$this->bindQueryParams($sql, $paramType, $paramValues);

		$sql->execute();

		return $sql->insert_id;
	}

	private function bindQueryParams($sql, $paramType, array $paramValues): void
	{
		$reference[] = &$paramType;
		for ($i = 0; $i < count($paramValues); $i ++)
		{
			$reference[] = &$paramValues[$i];
		}

		call_user_func_array([$sql, 'bind_param'], $reference);
	}
}
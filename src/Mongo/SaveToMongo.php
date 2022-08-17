<?php

namespace VKGroupMembers2Mongo\Mongo;
//use MongoDB\Client;

class SaveToMongo
{
	private $client;
	private $db_name;
	private $co_name;
	
	function __construct ($arg)
	{
		try
		{
			$this->client = new \MongoDB\Client($arg);
		}
		catch (\Exception $e)
		{
			exit('ОШИБКА при работе с MongoDB: ' . $e->getMessage());
		}
	}
	public function selectCollection($db_name, $co_name)
	{
		if (empty($db_name) || empty($co_name))
		{
			exit('ОШИБКА при работе с MongoDB: не указано имя базы или коллекции');
		}
		$this->db_name = $db_name;
		$this->co_name = $co_name;
	}
	public function saveData($arg)
	{
		try
		{
			$col = $this->client->selectCollection($this->db_name, $this->co_name);
			$col->insertMany($arg);
		}
		catch (\Exception $e)
		{
			exit('ОШИБКА при работе с MongoDB: ' . $e->getMessage());
		}
	}
}

?>
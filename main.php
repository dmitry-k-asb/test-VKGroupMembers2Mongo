<?php

require_once 'vendor/autoload.php';

use VKGroupMembers2Mongo\VK\VKAllMembersQuery;
use VKGroupMembers2Mongo\Mongo\SaveToMongo;

if ($argc < 2 || is_null($argv[1]))
{
	exit('Не указан ID группы');
}
$group_id = $argv[1];
$ini = @parse_ini_file('config.ini');
if (isset($ini['access_token'], $ini['connection_string'], $ini['database_name'], $ini['collection_name']))
{
	$access_token      = $ini['access_token'];
	$connection_string = $ini['connection_string'];
	$database_name     = $ini['database_name'];
	$collection_name   = $ini['collection_name'];
}
else
{
	exit('Не удалось загрузить параметры из config.ini');
}

$vk = new VKAllMembersQuery();
$vk->query($access_token, $group_id);
echo 'Всего собрано: ' . $vk->getCount() . PHP_EOL;
$members = $vk->getCollectedItems();

$mongo = new SaveToMongo($connection_string);
$mongo->selectCollection($database_name, $collection_name);
$mongo->saveData($members);


?>
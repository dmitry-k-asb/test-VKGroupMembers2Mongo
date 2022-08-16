<?php

if ($argc < 2 || is_null($argv[1]))
{
	exit('Не указан ID группы');
}
$group_id = $argv[1];
$ini = parse_ini_file('config.ini');
if (empty($ini))
{
	exit('Не удалось загрузить параметры из config.ini');
}
$access_token      = $ini['access_token'];
$connection_string = $ini['connection_string'];
$database_name     = $ini['database_name'];
$collection_name   = $ini['collection_name'];
var_dump($ini);
require 'vkallmembersquery.php';
require 'savetomongo.php';

$vk = new VKAllMembersQuery();
$vk->query($access_token, $group_id);
echo 'Всего собрано: ' . $vk->getCount() . PHP_EOL;
$members = $vk->getCollectedItems();

// $mongo = new SaveToMongo($connection_string);
// $mongo->selectCollection($database_name, $collection_name);
// $mongo->saveData($members);


?>
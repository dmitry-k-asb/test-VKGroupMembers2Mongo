<?php

$access_token = 'введите токен';
$group_id          = 'введите идентификатор группы';
$connection_string = 'введите строку подключения к MongoDB';
$database          = 'введите имя базы';
$collection        = 'введите имя коллекции';

require 'vkallmembersquery.php';
require 'savetomongo.php';

$vk = new VKAllMembersQuery();
$vk->query($access_token, $group_id);
echo 'Всего собрано: ' . $vk->getCount() . PHP_EOL;
$members = $vk->getCollectedItems();

$mongo = new SaveToMongo($connection_string);
$mongo->selectCollection($database, $collection);
$mongo->saveData($members);


?>
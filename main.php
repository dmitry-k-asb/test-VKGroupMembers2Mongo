<?php

$access_token = 'vk1.a.DzdWvHdhlXu--x8QAgU1kE1b5J_BEotxEQCbd6QdXBZo5F3m4g4wKQ7_mJEBVSqPsx44lcJprhDaMiMwuwXffPMqyv2UUZ16rZfHWbv7arCKh1Hq7W4eab20o_vdlH_0QUW6NFNfzelHW9mCcixKwMP1cGKAN6moxuoIa4r2YrzqDNRjsJEp7Vwnyi7wbfvG';
$group_id          = '215251375';
$connection_string = 'mongodb://localhost:27017';
$database          = 'qwe';
$collection        = 'qwe';

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
# test-VKGroupMembers2Mongo
<!DOCTYPE html>
<html>
  <body>
    <b> Тестовый проект: </b><br>
    Сбор всех пользователей VK сообщества (+добавление поля 'Возраст') в коллекцию MongoDB<br><br>
    <b> Используется: </b><br>
    <ol>
      <li>PHP</li>
      <li>VK API - функции groups.getMembers и execute</li>
      <li>MongoDB</li>
      <li>Composer - подключение библиотеки для работы с MongoDB и автозагрузчик PSR-4</li>
    </ol>
    <b> Инструкция: </b><br>
    <ol>
      <li>Установить PHP, MongoDb (+расширение-драйвер), Composer</li>
      <li>Выполните команду composer install в корневой директории проекта</li>
      <li>Укажите свои параметры в файле config.ini</li>
	  <li>Запустите файл main.php с параметром - ID группы</li>
    </ol>	
  </body>
</html>

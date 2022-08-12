# test-VKGroupMembers2Mongo
<!DOCTYPE html>
<html>
  <body>
    <b> Тестовый проект: </b><br>
    Сбор пользователей VK сообщества (+добавить поле возраст) в коллекцию MongoDB<br>
    <b> Используется: </b><br>
    1.  PHP<br>
    2.  VK API - функции groups.getMembers и execute<br>
    3.  MongoDB<br>
    4.  Composer<br>
    <b> Инструкция: </b><br>
    1.  Установить PHP, MongoDb (+расширение-драйвер), Composer.<br>
    2.  Установить пакет классов для работы с MongoDB с помощью Composer.<br>
    3.  Подключить класс VKAllMembersQuery.<br>
    3.1  используем метод query(1 аргумент - токен доступа к VK API, 2 аргумент - идентификатор группы) метод возращает true/false+выдает ошибку.<br>
    3.2  методы getColleрctedItems() и getCount() вернут массив собранных пользователей и количество соответственно.<br>
    4.  Подключить класс SaveToMongo.<br>
    4.1  В конструктор объекта передаем строку подключения к MongoDB серверу<br>
    4.2  Использум методы selectDB (аргумент - имя базы на сервере MongoDB) и selectCollection(аргумент - имя коллекции на сервере MongoDB)<br>
    4.3  Метод saveData(аргумент - переменная с данными для сохранения) сохранит в указанную коллекцию или выдаст исключение.
  </body>
</html>

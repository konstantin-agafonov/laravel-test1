## Задача

Написать микросервис работы с гостями используя язык программирования PHP, БД MySql и фреймворк Laravel.

Микросервис реализует API для CRUD операций над гостем. То есть принимает данные для создания, изменения, получения, удаления записей гостей хранящихся в выбранной базе данных.

Сущность "Гость" Имя, фамилия и телефон – обязательные поля. А поля телефон и email уникальны. В итоге у гостя должны быть следующие атрибуты: идентификатор, имя, фамилия, email, телефон, страна. Если страна не указана то доставать страну из номера телефона +7 - Россия и т.д.

Микросервис должен запускаться в Docker.

## Запуск приложения

1. Клонировать репозиторий
```console
foo@bar:~$ whoami
git clone git@github.com:konstantin-agafonov/laravel-test1.git
cd laravel-test1
```

2. Если запущены локальный веб-сервер и/или сервисы БД, то остановить их, чтобы не было конфликтов.
Например, в Ubuntu:
```console
sudo systemctl stop apache
sudo systemctl stop mariadb
```

3. В папке проекта создать файл .env и скопировать в него всё содержимое файла .env.example


4. Запустить Sail
```console
./vendor/bin/sail up
```

5. Запустить миграцию
```console
./vendor/bin/sail artisan migrate
```

Приложение запущено и готово к использованию.

## Описание API

Приложение доступно по url http://localhost:8123/

Ко всем запросам необходимо добавлять заголовок Accept: application/json

{guest} - параметр с ID гостя


GET|HEAD        http://localhost:8123/api/guests .....................Получение списка гостей

POST            http://localhost:8123/api/guests .....................Создание нового гостя

Тело запроса в формате JSON:
```
{
"name": "<Имя гостя>",                      // Обязательный
"surname": "<Фамилия гостя>",               // Обязательный
"phone": "<Телефон>",                       // Обязательный, уникальный, должен начинаться с +<код страны>
"email": "<Email>"                          // Необязательный, уникальный                          
"contry": "<код страны>"                    // Необязательный, cтандартный код страны из двух символов
}
```

GET|HEAD        http://localhost:8123/api/guests/{guest} .............Получить данные гостя

PUT|PATCH       http://localhost:8123/api/guests/{guest} .............Обновить данные гостя

Тело запроса то же что и при создании нового гостя

DELETE          http://localhost:8123/api/guests/{guest} .............Удалить гостя

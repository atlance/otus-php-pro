## Docker.

### Материалы:
- [PhpStorm — как подключиться к GitHub](https://ploshadka.net/phpstorm-github/)
- [Интеграция VSCode с GitHub](https://channel9.msdn.com/Series/Visual-Studio-Code----Mac/code6)
- [Git - Book](https://git-scm.com/book/ru/v2)
- [Шпаргалка по git-flow](https://danielkummer.github.io/git-flow-cheatsheet/index.ru_RU.html)
- [Список литературы.txt](https://gist.github.com/atlance/85410bd2476f43cb34c92ada351d2b8d)
- [Laravel Homestead - Laravel - The PHP Framework For Web Artisans](https://laravel.com/docs/8.x/homestead)
- [Downloads | Vagrant by HashiCorp](https://www.vagrantup.com/downloads)
- [Downloads – Oracle VM VirtualBox](https://www.virtualbox.org/wiki/Downloads)

### Описание/Пошаговая инструкция выполнения задания:
1. Установить **Docker** себе на локальную машину.
2. Описать инфраструктуру в **docker-compose**, которая включает в себя:
- **nginx** (обрабатывает статику, пробрасывает выполнение скриптов в fpm).
- **php-fpm** (соединяется с `nginx` через **unix-сокет**).
- **redis** (соединяется с `php` по порту).
- **memcached** (соединяется с `php` по порту).
3. БД подключать как отдельную `VM` (можно на базе `Homestead`), либо как контейнер (но тогда не забудьте про директории с данными).
4. Не забудьте про `Composer`.

### Виртуальные машины.
1.  Развернуть `Homestead VM` при помощи `Vagrant` и `VirtualBox`.
2.  Сайт должен отвечать на доменное имя **application.local**.
3.  Должна быть поддержка проброса директорий.

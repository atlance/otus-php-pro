## Проектирование API.

### Материалы
- [Стажёр Вася и его истории об идемпотентности API](https://habr.com/ru/company/yandex/blog/442762/)
- [Стажёр Вася и его опыт разработки нового API](https://habr.com/ru/company/yandex/blog/583332/)
- [REST API error return good practices](https://stackoverflow.com/questions/942951/rest-api-error-return-good-practices)

#### Описание/Пошаговая инструкция выполнения задания:
- Необходимо реализовать `REST API` с использованием очередей.
- Ваши клиенты будут отправлять запросы на обработку, а вы будете складывать их в очередь и возвращать номер запроса.
- В фоновом режиме вы будете обрабатывать запросы, а ваши клиенты периодически, используя номер запроса, будут проверять статус его обработки.

#### Критерии оценки:
- 5 баллов за реализацию `API`;
- 3 балла за применение очередей;
- 2 балла за документацию (например, в `Swagger`).

## Результат:
- `Docker`.
- `Supervisor`.
- `Clean architecture`.
- `CQRS`.
- `Symfony Messenger`.
- `Symfony Lock`.
- `RabbitMQ`.
- `OpenApi/Swagger`.

### Запуск: основные команды
1. `make init` - сообираются контейнеры, запускается сервис.
2. `make consume` - запуск консьюмеров в фоновом режиме.
3. `make tests` - команда запускает тесты.

#### API Документация http://application.local:8081/api/doc
#### RabbitMQ Manager: http://application.local:15672/
- `user`:`user`
- `password`:`pass`
#### MailHog: http://application.local:8082/

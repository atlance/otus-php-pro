## Тестирование.

### Материалы
- [Зачем и как писать качественные Unit-тесты (Алексей Солодкий / Badoo)](https://www.youtube.com/watch?v=Rz4S0v7K7Ho)
- [Мутационное тестирование](https://habr.com/ru/articles/334394/)
- [Mockery — Mockery Docs 1.0-alpha documentation](http://docs.mockery.io/en/latest/)
- [infection/infection PHP Mutation Testing library](http://docs.mockery.io/en/latest/)
- [PHPUnit Manual](https://phpunit.readthedocs.io/en/9.5/)
- [Изучаем классы эквивалентности](https://ru.hexlet.io/courses/qa-engineer-workflow/lessons/test-design-techniques/theory_unit#:~:text=%D0%93%D1%80%D0%B0%D0%BD%D0%B8%D1%87%D0%BD%D1%8B%D0%B5%20%D0%B7%D0%BD%D0%B0%D1%87%D0%B5%D0%BD%D0%B8%D1%8F%20%E2%80%93%20%D1%8D%D1%82%D0%BE%20%D0%B7%D0%BD%D0%B0%D1%87%D0%B5%D0%BD%D0%B8%D1%8F,%20%D0%B2,%D0%BD%D0%B0%D0%BF%D0%B8%D1%81%D0%B0%D0%BD%D0%B8%D0%B8%20%D0%BA%D0%BE%D0%B4%D0%B0%20%D0%B8%20%D1%84%D0%BE%D1%80%D0%BC%D1%83%D0%BB%D0%B8%D1%80%D0%BE%D0%B2%D0%B0%D0%BD%D0%B8%D0%B8%20%D1%82%D1%80%D0%B5%D0%B1%D0%BE%D0%B2%D0%B0%D0%BD%D0%B8%D0%B9.)

#### Описание/Пошаговая инструкция выполнения задания:
1. Перед Вами поставлена задача реализовать бэк для страницы оплаты просмотра фильма через некий платёжный сервис `А`.
   Рассмотрим упрощённую схему, подразумевающую, что сервис сразу отвечает нам о возможности списания средств, без дополнительной авторизации через `3-D-Secure`.
   Фронт для этой страницы уже реализован, он передаёт `JSON`-объект, содержащий текстовые поля
- `card_number` (номер карты, **16** цифр, считаем, что валидный номер всегда содержит **16** цифр, валидность номера по алгоритму Луна проверять не нужно)
- `card_holder` (владелец карты, имя и фамилия латиницей, может также содержать дефис)
- `card_expiration` (месяц/год окончания действия карты в формате мм/гг)
- `cvv` (код с обратной стороны карты, **3 цифры**)
- `order_number`(номер заказа, до **16** произвольных символов)
- `sum` (сумма оплаты, разделитель дробной и целой части запятая, поэтому и строка, а не число).

Бэк состоит из одного метода контроллера и выполняет следующие действия:
- Валидирует данные, если в данных есть ошибка, то возвращает сообщение об ошибке с кодом `400`;
- Если данные верные, то передаёт их в `API`-запросе на сервис `A`. Сервис `A` пытается списать деньги, если ему это не удаётся, то он возвращает `HTTP`-код `403`, если удаётся, то `HTTP`-код `200`;
- В случае ошибки передаём её обратно на фронт.
- В случае успешного списания денег необходимо записать в `БД` информацию об успешной оплате. Предполагаем, что у нас есть соответствующий метод репозитория `setOrderIsPaid(string $orderNumber, float $sum): bool`, реализованный ранее. Метод проверяет соответствие номера заказа и его суммы и возвращает `true`, если списание успешно. В случае ошибок выбрасываются различные исключения.

2. Предлагается описать кейсы тестирования данной задачи для трёх уровней: `модульного`, `интеграционного` и `системного`.  
   Считаем, что взаимодействуют 4 «модуля»: бэк, фронт, репозиторий и сервис `A`.  
   Кейсы тестирования предлагается описывать примерно так:

    1. **Модульные тесты**:
        1. Если `card_holder` содержит более одного пробела, то тестируемый метод возвращает `400` с сообщением об ошибке;
        2. …
    2. **Интеграционные тесты**:
        1. Проверяем связку «фронт-бэк»:
        - Если card_holder содержит более одного пробела, то после получения ответа от бэка на фронте выделяется поле «Номер карты» красной рамкой;
        - …
        2. Проверяем связку «бэк-репозиторий»:
        - …
    3. **Системные тесты**:
        1. Если `cvv` неверен, то после получения ответа от бэка на фронте выводится сообщение об ошибке `«Не удалось списать данные с карты, проверьте реквизиты»`.


Поведение фронта в случае ошибок можете выбрать произвольное, но консистентное, т.е. при ошибках одинакового уровня поведение должно быть одинаковым. Пример неконсистентного поведения:
- при ошибке в `card_number` выделяется поле `«Номер карты»` красной рамкой
- при ошибке в формате `card_expiration` закрывается браузер с ошибкой `Out of memory`.

#### Критерии оценки:
- Модульные кейсы покрывают все возможные примеры невалидных данных;
- Интеграционные и системные кейсы правильно разделены по уровням, т.е. нет системных кейсов внутри раздела интеграционных и наоборот;
- Есть хотя бы по два интеграционных кейса для каждой связки и хотя бы два системных;
- Предложенные кейсы гарантируют, что в итоге пользователь сможет воспользоваться реализованной страницей, и это учтено на каждом уровне (это некая подсказка, более подробно могу сформулировать только после первой попытки сдачи работы);

**Дополнительные замечания**:
- Необязательно переносить на уровень выше **все** тесты, но желательно перенести хотя бы те, которые проверяют сильно отличающееся поведение;
- Следуем правилу «не нужно проверять чужой код»: если то, что наш модуль передаёт другому, должно приводить к схожим результатам, то достаточно одного теста;
- Поскольку мы тестируем оплату, то стоимость тестирования в некоторых ситуациях будет выражаться в реальных денежных затратах, а не в виртуальных. Стоит обратить на это внимание и, возможно, предложить способы удешевления тестирования.

### Результат:
Написана система из 2 бекенд модулей:
- `app` - сервис проксирующий списание средств через `bank gateway`.
- `bank` - сервис списания средств.

Если представить, что `bank gateway` платный сервис, то для тестов учтен этот факт, через [конфигурацию](./../app/src/Resources/config/test/services.yaml) где мы переопределяем хэндлеры.

### Запуск: основные команды
1. `make init` - сообираются контейнеры, запускается сервис.
2. `make tests` - команда запускает тесты.
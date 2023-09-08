## Сети, протоколы. Балансировка. Безопасность.

### Материалы:
- [Балансировка бэкендов с помощью Nginx](https://ruhighload.com/%D0%91%D0%B0%D0%BB%D0%B0%D0%BD%D1%81%D0%B8%D1%80%D0%BE%D0%B2%D0%BA%D0%B0+%D0%B1%D1%8D%D0%BA%D0%B5%D0%BD%D0%B4%D0%BE%D0%B2+%D1%81+%D0%BF%D0%BE%D0%BC%D0%BE%D1%89%D1%8C%D1%8E+nginx)
- [Сети для самых маленьких. Часть нулевая. Планирование / linkmeup](https://linkmeup.ru/blog/11.html)
- [OWASP Top Ten Web Application Security Risks | OWASP](https://owasp.org/www-project-top-ten/)

### Описание/Пошаговая инструкция выполнения задания:
- Приложение верификации `email`.
- Реализовать приложение (сервис/функцию) для верификации `email`.
- Реализация будет в будущем встроена в более крупное решение.
- Минимальный функционал - список строк, которые необходимо проверить на наличие валидных email.
- Валидация по регулярным выражениям и проверке DNS mx записи, без полноценной отправки письма-подтверждения.

### Результат.
```php
use Atlance\EmailValidator\EmailValidator;

EmailValidator::isValid
```

Для проверки(тестов): `composer install && composer tests`.

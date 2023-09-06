## Другие SQL-решения. ElasticSearch.

### Материалы
- [Elasticsearch Guide](https://www.elastic.co/guide/en/elasticsearch/reference/current/index.html)
- [ElasticSearch — как мы делали свою речевую аналитику](https://habr.com/ru/company/tinkoff/blog/595277/)
- [Elasticsearch: Text vs. Keyword](https://codecurated.com/blog/elasticsearch-text-vs-keyword/)
- [Part I: How Elasticsearch Works Internally](https://buildatscale.tech/how-elasticsearch-works-internally/)
- [Part II: How Elasticsearch Works Internally](https://buildatscale.tech/elasticsearch-internals/)
- [Изучаем ELK. Часть I — Установка Elasticsearch](https://habr.com/ru/post/538840/)
- [Изучаем ELK. Часть II — Установка Kibana и Logstash](https://habr.com/ru/post/538974/)
- [Что такое ClickHouse | ClickHouse Docs](https://clickhouse.com/docs/ru)
- [books.json](https://gist.github.com/atlance/193f803fe70c6fb2aba901440e6c97b4)

#### Описание/Пошаговая инструкция выполнения задания:
- Реализуем поиск по книжному интернет-магазину с помощью `Elasticsearch`.
- У каждого товара есть название, категория, цена и кол-во остатков на складе.  
- Поиск должен корректно работать с опечатками и русской морфологией.  
- **Пример**: пользователь ищет все исторические романы дешевле 2000 рублей (и в наличии) по поисковому запросу "рыцОри".  
- В результате должны вернуться товары, ранжированные по релевантности.  
- Домашку нужно сдать как консольное PHP-приложение, которое принимает один или несколько параметров командной строки и выводит результат в виде текстовой таблички, после чего завершает работу.  
- `JSON` с товарами будет приложен к занятию в ЛК.  
- Способ создания индекса и его первоначального заполнения — на ваш выбор.  

**Критерии оценки**:
- [x] Работа c ES при помощи готовых библиотек.  
- [x] Выделен слой кода, отвечающий за работу с хранилищем.  

#### Результат:
1. `make init` - сообираются контейнеры, запускается сервис.  
Для РФ - включить `VPN`.
2. `make dump-restore` - накатить БД(потребуется немного времени для индексации данных).
3. `make search` - команда для поиска книг.  

Пример использования:
```bash
filter="--title='рыцОри' --category='Детектив' --rangePrice='gte=744&lt=800' --street='Мира' --rangeStock='lte=10'" make search
```

-- Фильм, задачи актуальные на сегодня, задачи актуальные через 20 дней. --
CREATE OR REPLACE VIEW movies_tasks_today_and_after_20_days AS
SELECT m.title, m.today_movies_tasks AS today, m.after_20_days_movies_tasks AS after_20_days
FROM movies AS m;
COMMENT ON VIEW movies_tasks_today_and_after_20_days
    IS 'Фильм, задачи актуальные на сегодня, задачи актуальные через 20 дней.';

-- Фильм, тип атрибута, атрибут, значение (значение выводим как текст). --
CREATE OR REPLACE VIEW movies_attributes_values AS
SELECT m.title,
       t.title AS attribute_type,
       a.title AS attribute_name,
       COALESCE(
           v.value_text::TEXT,
           v.value_integer::TEXT,
           v.value_boolean::TEXT,
           v.value_float::TEXT,
           v.value_datetime::TEXT
       ) AS attribute_value
FROM attributes_values AS v
    LEFT JOIN movies AS m ON m.id =  v.entity_id
    LEFT JOIN attributes AS a ON a.id = v.attribute_id
    LEFT JOIN attributes_type AS t ON a.type_id = t.id
ORDER BY m.title, t.title, a.title;
COMMENT ON VIEW movies_attributes_values
    IS 'Фильм, тип атрибута, атрибут, значение (значение выводим как текст).';

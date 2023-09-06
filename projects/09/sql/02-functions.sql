-- Добавить тип атрибута. --
CREATE OR REPLACE FUNCTION add_attribute_type(
    at_title TEXT,
    at_type TEXT DEFAULT 'TEXT'
) RETURNS UUID AS $$
DECLARE at_id UUID;
BEGIN

    at_id = (SELECT id FROM attributes_type WHERE title = at_title);

    IF (at_id IS NULL) THEN
        INSERT INTO attributes_type (title, type)
        VALUES (at_title, at_type)
        RETURNING id INTO at_id;
    END IF;

    RETURN at_id;
END;
$$ LANGUAGE plpgsql;
COMMENT ON FUNCTION add_attribute_type IS 'Добавить тип атрибута.';

-- Добавить атрибут. --
CREATE OR REPLACE FUNCTION add_attribute(
    a_title TEXT,
    at_id UUID
) RETURNS UUID AS $$
DECLARE
    a_id UUID;
BEGIN

    a_id = (SELECT id FROM attributes WHERE title = a_title AND type_id = at_id);

    IF (a_id IS NULL) THEN
        INSERT INTO attributes (title, type_id)
        VALUES (a_title, at_id)
        RETURNING id INTO a_id;
    END IF;

    RETURN a_id;
END;
$$ LANGUAGE plpgsql;
COMMENT ON FUNCTION add_attribute IS 'Добавить атрибут.';

-- Определяем колонку для записи значения атрибута. --
CREATE OR REPLACE FUNCTION get_attribute_column_name_by_value(ANYELEMENT) RETURNS VARCHAR AS $$
BEGIN
    RETURN CASE pg_typeof($1)::TEXT
        -- Целочисленный тип. --
        WHEN 'smallint' THEN 'value_integer'
        WHEN 'integer' THEN 'value_integer'
        WHEN 'bigint' THEN 'value_integer'
        -- Дата/Дата и время. --
        WHEN 'date' THEN 'value_datetime'
        WHEN 'timestamp with time zone' THEN 'value_datetime'
        WHEN 'timestamp without time zone' THEN 'value_datetime'
        WHEN 'time with time zone' THEN 'value_datetime'
        WHEN 'time without time zone' THEN 'value_datetime'
        -- Логический тип. --
        WHEN 'boolean' THEN 'value_boolean'
        -- Плавающая точка. --
        WHEN 'double precision' THEN 'value_float'
        WHEN 'numeric' THEN 'value_float'
        WHEN 'real' THEN 'value_float'
        -- Всё прочее как текст. --
        ELSE 'value_text'
    END;
END
$$ LANGUAGE plpgsql;

-- Перегружаем функцию выше. Всё что не ANYELEMENT попадает сюда. --
CREATE OR REPLACE FUNCTION get_attribute_column_name_by_value(TEXT) RETURNS VARCHAR AS $$
BEGIN
    RETURN 'value_text';
END
$$ LANGUAGE plpgsql;


-- Добавить значение атрибуту. --
CREATE OR REPLACE FUNCTION add_attribute_value(
    e_id UUID,
    a_id UUID,
    value ANYELEMENT
) RETURNS UUID AS $$
DECLARE
    av_id UUID;
BEGIN
    EXECUTE FORMAT(
        'INSERT INTO attributes_values (entity_id, attribute_id, %I)' ||
        'VALUES ($1, $2, $3) ' ||
        'RETURNING id',
        get_attribute_column_name_by_value(value)
    ) INTO av_id USING e_id, a_id, value;

    RETURN av_id;
END
$$ LANGUAGE plpgsql;

-- Перегружаем функцию выше. Всё что не ANYELEMENT попадает сюда. --
CREATE OR REPLACE FUNCTION add_attribute_value(
    e_id UUID,
    a_id UUID,
    value TEXT
) RETURNS UUID AS $$
DECLARE
    av_id UUID;
BEGIN
    INSERT INTO attributes_values (entity_id, attribute_id, value_text)
    VALUES (e_id, a_id, value)
    RETURNING id INTO av_id;

    RETURN av_id;
END
$$ LANGUAGE plpgsql;

-- Задачи на сегодня. --
CREATE OR REPLACE FUNCTION today_movies_tasks(movies) RETURNS TEXT AS $$
BEGIN
    RETURN (
        SELECT string_agg(a.title, ', ')
        FROM attributes_values AS v
            LEFT JOIN attributes AS a ON v.attribute_id = a.id
            LEFT JOIN attributes_type AS t ON a.type_id = t.id
        WHERE v.entity_id = $1.id AND
              v.value_datetime = CURRENT_DATE AND
              t.title = 'Служебная дата'
    );
END;
$$ LANGUAGE plpgsql;
COMMENT ON FUNCTION today_movies_tasks IS 'Задачи на сегодня.';

-- Задачи через 20 дней. --
CREATE OR REPLACE FUNCTION after_20_days_movies_tasks(movies) RETURNS TEXT AS $$
BEGIN
    RETURN (
        SELECT string_agg(a.title, ', ')
        FROM attributes_values AS v
            LEFT JOIN attributes AS a ON v.attribute_id = a.id
            LEFT JOIN attributes_type AS t ON a.type_id = t.id
        WHERE v.entity_id = $1.id AND
              v.value_datetime = CURRENT_DATE + INTERVAL '20 days' AND
              t.title = 'Служебная дата'
    );
END;
$$ LANGUAGE plpgsql;
COMMENT ON FUNCTION after_20_days_movies_tasks IS 'Задачи через 20 дней.';

------------------------------------------ Время выполнения запроса. ---------------------------------------------------
CREATE OR REPLACE FUNCTION execution_time(query TEXT) RETURNS jsonb AS $$
DECLARE
    data jsonb;
BEGIN
    EXECUTE 'EXPLAIN (ANALYSE, FORMAT JSON)' || query INTO data;
    RETURN (data->0->'Execution Time')::DECIMAL;
END;
$$ LANGUAGE plpgsql;
COMMENT ON FUNCTION execution_time IS 'Время исполнения запроса.';
------------------------------------------------------------------------------------------------------------------------
------------------------------------------ Генерация целого числа. -----------------------------------------------------
CREATE OR REPLACE FUNCTION int_between(low INT ,high INT) RETURNS INT AS $$
BEGIN
    RETURN floor(random()* (high-low + 1) + low);
END;
$$ LANGUAGE plpgsql;
COMMENT ON FUNCTION int_between IS 'Генерация целого числа.';
------------------------------------------------------------------------------------------------------------------------
--------------------------------------- Генерация диапазона дат и времени. ---------------------------------------------
CREATE OR REPLACE FUNCTION datetime_interval(
    from_date TIMESTAMP,
    to_date TIMESTAMP,
    from_time INTERVAL,
    end_time INTERVAL,
    hours INTERVAL
) RETURNS TABLE (date_time TIMESTAMP) AS $$
BEGIN
    RETURN QUERY (
        SELECT t.*
        FROM (SELECT generate_series(from_date, to_date, hours) AS date_time) AS t
        WHERE t.date_time::TIME BETWEEN from_time AND end_time
    );
END;
$$ LANGUAGE plpgsql;
COMMENT ON FUNCTION datetime_interval IS 'Генерация диапазона дат и времени.';
------------------------------------------------------------------------------------------------------------------------
------------------------------------------- Генерация кинозалов. -------------------------------------------------------
CREATE OR REPLACE FUNCTION generate_halls(count INT) RETURNS VOID AS $$
BEGIN
    FOR i IN 1..count LOOP
        INSERT INTO halls (id, title)
        VALUES (uuid_generate_v4(), CONCAT('hall - ', i));
    END LOOP;
END;
$$ LANGUAGE plpgsql;
COMMENT ON FUNCTION generate_halls IS 'Генерация кинозалов.';
------------------------------------------------------------------------------------------------------------------------
------------------------------------------ Генерация мест в кинозалы. --------------------------------------------------
CREATE OR REPLACE FUNCTION generate_halls_places(rows_count INT, place_count INT) RETURNS VOID AS $$
BEGIN
    FOR i IN 1..rows_count LOOP
        INSERT INTO halls_places (id, hall_id, row, place)
        SELECT uuid_generate_v4(), h.id, i, generate_series(1, place_count)
        FROM halls AS h;
    END LOOP;
END;
$$ LANGUAGE plpgsql;
COMMENT ON FUNCTION generate_halls_places IS 'Генерация мест в кинозалы.';
------------------------------------------------------------------------------------------------------------------------
------------------------------------------ Генерация фильмов. ----------------------------------------------------------
CREATE OR REPLACE FUNCTION generate_movies(count INT) RETURNS VOID AS $$
BEGIN
    FOR i IN 1..count LOOP
        INSERT INTO movies (id, title)
        VALUES (uuid_generate_v4(), CONCAT('movie - ', i));
    END LOOP;
END;
$$ LANGUAGE plpgsql;
COMMENT ON FUNCTION generate_movies IS 'Генерация фильмов.';
------------------------------------------------------------------------------------------------------------------------
--------------------------------- Генерация сеансов и билетов в кинозал. -----------------------------------------------
CREATE OR REPLACE FUNCTION generate_sessions(
    start_date TIMESTAMP,
    end_date TIMESTAMP,
    start_time INTERVAL,
    end_time INTERVAL,
    hours INTERVAL
) RETURNS VOID AS $$
DECLARE
    hall_identity UUID;
    start_at TIMESTAMP;
    session_id UUID;
BEGIN
    FOR hall_identity IN SELECT id FROM halls LOOP
        FOR start_at IN SELECT datetime_interval(start_date, end_date, start_time, end_time, hours) LOOP
            INSERT INTO sessions (id, movie_id, hall_id, price, start_date_at, start_time_at)
            SELECT uuid_generate_v4(),
                   (SELECT id FROM movies ORDER BY random() LIMIT 1),
                   hall_identity,
                   int_between(100,200),
                   start_at,
                   start_at
            RETURNING id INTO session_id;

            INSERT INTO tickets (id, session_id, hall_place_id, price, payment_at)
            SELECT uuid_generate_v4(), session_id, hp.id, int_between(100,350), start_at
            FROM halls_places AS hp
            WHERE hp.hall_id = hall_identity;

        END LOOP;
    END LOOP;
END;
$$ LANGUAGE plpgsql;
COMMENT ON FUNCTION generate_sessions IS 'Генерация сеансов и билетов в кинозал.';
------------------------------------------------------------------------------------------------------------------------
------------------------------------ Генерация всех данных. ------------------------------------------------------------
CREATE OR REPLACE FUNCTION generate_all(
    movies_count INT,
    halls_count INT,
    rows_count INT,
    place_count INT,
    start_date TIMESTAMP,
    end_date TIMESTAMP,
    start_time INTERVAL,
    end_time INTERVAL,
    hours INTERVAL
) RETURNS VOID AS $$
BEGIN
    PERFORM generate_movies(movies_count);
    PERFORM generate_halls(halls_count);
    PERFORM generate_halls_places(rows_count, place_count);
    PERFORM generate_sessions(start_date, end_date, start_time, end_time, hours);
END;
$$ LANGUAGE plpgsql;
COMMENT ON FUNCTION generate_all IS 'Генерация всех данных.';
------------------------------------------------------------------------------------------------------------------------
---------------------------------------------- Схема кинозала. ---------------------------------------------------------
CREATE OR REPLACE FUNCTION places(sessions) RETURNS TEXT AS $$
BEGIN
    RETURN (
        SELECT json_agg(scheme) AS scheme
        FROM (
            SELECT json_build_object(
                'id', hp.id,
                'row', hp.row,
                'place', hp.place,
                'is_available', (t.price IS NULL)
            ) AS scheme
            FROM tickets AS t
                LEFT JOIN halls_places hp ON hp.id = t.hall_place_id
            WHERE t.session_id = $1.id
            ORDER BY hp.row, hp,place
        ) AS scheme
    );
END;
$$ LANGUAGE plpgsql;
COMMENT ON FUNCTION places IS 'Схема кинозала.';
------------------------------------------------------------------------------------------------------------------------
----------------------------------- Минимальная цена за билет на сеанс. ------------------------------------------------
CREATE OR REPLACE FUNCTION min_ticket_price(sessions) RETURNS SMALLINT AS $$
DECLARE
    ticket_price SMALLINT;
BEGIN
    SELECT MIN(t.price)
    FROM tickets AS t
    WHERE t.session_id = $1.id
    INTO ticket_price;

    IF (ticket_price IS NULL) THEN
        ticket_price = $1.price;
    END IF;

    RETURN ticket_price;
END;
$$ LANGUAGE plpgsql;
COMMENT ON FUNCTION min_ticket_price IS 'Минимальная цена за билет на сеанс.';
------------------------------------------------------------------------------------------------------------------------
----------------------------------- Максимальная цена за билет на сеанс. -----------------------------------------------
CREATE OR REPLACE FUNCTION max_ticket_price(sessions) RETURNS SMALLINT AS $$
DECLARE
    ticket_price SMALLINT;
BEGIN
    SELECT MAX(t.price)
    FROM tickets AS t
    WHERE t.session_id = $1.id
    INTO ticket_price;

    IF (ticket_price IS NULL) THEN
        ticket_price = $1.price;
    END IF;

    RETURN ticket_price;
END;
$$ LANGUAGE plpgsql;
COMMENT ON FUNCTION max_ticket_price IS 'Максимальная цена за билет на сеанс.';
------------------------------------------------------------------------------------------------------------------------

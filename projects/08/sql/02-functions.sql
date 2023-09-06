CREATE OR REPLACE FUNCTION generate_places(hall_title VARCHAR(255), rows_count INT, place_count INT) RETURNS VOID AS $$
DECLARE
    hall_identity SMALLINT;
BEGIN
    hall_identity = (SELECT id FROM halls WHERE title = hall_title);

    FOR row IN 1..rows_count LOOP
        FOR place IN 1..place_count LOOP
            INSERT INTO halls_places (hall_id, row, place) VALUES (hall_identity, row, place);
        END LOOP;
    END LOOP;
END;
$$ LANGUAGE plpgsql;
COMMENT ON FUNCTION generate_places IS 'Генерация мест в кинозалы.';

CREATE OR REPLACE FUNCTION create_session(
    movie_title TEXT,
    hall_title TEXT,
    session_start TIMESTAMP WITHOUT TIME ZONE,
    ticket_price INT
) RETURNS SMALLINT AS $$
DECLARE
    identity SMALLINT;
    movie_identity SMALLINT;
    hall_identity SMALLINT;
BEGIN
    movie_identity = (SELECT id FROM movies WHERE title = movie_title);
    hall_identity = (SELECT id FROM halls WHERE title = hall_title);

    INSERT INTO sessions (movie_id, hall_id, start_at, price)
    VALUES (movie_identity, hall_identity, session_start, ticket_price)
    RETURNING id INTO identity;

    RETURN identity;
END;
$$ LANGUAGE plpgsql;
COMMENT ON FUNCTION create_session IS 'Создание сеанса в кинозал.';

CREATE OR REPLACE FUNCTION generate_tickets(
    movie_title TEXT,
    hall_title TEXT,
    session_start TIMESTAMP WITHOUT TIME ZONE,
    ticket_price INT
) RETURNS VOID AS $$
DECLARE
    movie_identity SMALLINT;
    hall_identity SMALLINT;
    session_identity SMALLINT;
BEGIN
    movie_identity = (SELECT id FROM movies WHERE title = movie_title);
    hall_identity = (SELECT id FROM halls WHERE title = hall_title);
    session_identity = (
        SELECT id
        FROM sessions
        WHERE movie_id = movie_identity AND
                hall_id = hall_identity AND
                start_at = session_start
    );

    IF (session_identity IS NULL) THEN
        session_identity = (SELECT create_session(movie_title, hall_title, session_start, ticket_price));
    END IF;



    INSERT INTO tickets (session_id, hall_place_id)
    SELECT session_identity, src.id
    FROM halls_places AS src
    WHERE src.hall_id = hall_identity;
END;
$$ LANGUAGE plpgsql;
COMMENT ON FUNCTION generate_tickets IS 'Генерация билетов в кинозал.';

CREATE OR REPLACE FUNCTION buy_ticket(
    movie_title TEXT,
    hall_title TEXT,
    row_number INT,
    place_number INT,
    session_start TIMESTAMP WITHOUT TIME ZONE,
    ticket_price INT = NULL
) RETURNS VOID AS $$
DECLARE
    movie_identity SMALLINT;
    hall_identity SMALLINT;
    session_identity SMALLINT;
    hall_place_identity SMALLINT;
BEGIN
    movie_identity = (SELECT id FROM movies WHERE title = movie_title);
    hall_identity = (SELECT id FROM halls WHERE title = hall_title);
    hall_place_identity = (
        SELECT hp.id
        FROM halls_places AS hp
        WHERE hp.hall_id = hall_identity AND hp.row = row_number AND hp.place = place_number
    );
    session_identity = (
        SELECT s.id
        FROM sessions AS s
        WHERE s.movie_id = movie_identity AND s.hall_id = hall_identity AND s.start_at = session_start
    );

    IF (ticket_price IS NULL) THEN
        ticket_price = (SELECT s.price FROM sessions AS s WHERE s.id = session_identity);
    END IF;

    UPDATE tickets
    SET price = ticket_price
    WHERE session_id = session_identity AND hall_place_id = hall_place_identity;
END;
$$ LANGUAGE plpgsql;
COMMENT ON FUNCTION buy_ticket IS 'Купить билет на фильм в кинозале.';
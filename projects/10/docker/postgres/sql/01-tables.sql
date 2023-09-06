------------------------------------------------------------------------------------------------------------------------
------------------------------------------- Кинозалы. ------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS halls
(
    id UUID NOT NULL,
    title VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);
COMMENT ON TABLE halls IS 'Кинозалы.';
COMMENT ON COLUMN halls.id IS 'Идентификатор.';
COMMENT ON COLUMN halls.title IS 'Название.';
------------------------------------------------------------------------------------------------------------------------
------------------------------------------- Места в кинозалы. ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS halls_places
(
    id UUID NOT NULL,
    hall_id UUID NOT NULL,
    row SMALLINT NOT NULL,
    place SMALLINT NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_halls_places_halls
        FOREIGN KEY (hall_id) REFERENCES halls
            DEFERRABLE
);
COMMENT ON TABLE halls_places IS 'Места в зале.';
COMMENT ON COLUMN halls_places.id IS 'Идентификатор.';
COMMENT ON COLUMN halls_places.hall_id IS 'Идентификатор кинозала.';
COMMENT ON COLUMN halls_places.row IS 'Ряд.';
COMMENT ON COLUMN halls_places.place IS 'Номер места.';
CREATE INDEX IF NOT EXISTS idx_halls_places_halls ON halls_places USING btree(hall_id);
CREATE UNIQUE INDEX IF NOT EXISTS unique_idx_hall_place ON halls_places (hall_id, row, place);
------------------------------------------------------------------------------------------------------------------------
------------------------------------------- Справочник фильмов. --------------------------------------------------------
CREATE TABLE IF NOT EXISTS movies
(
    id UUID NOT NULL,
    title VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);
COMMENT ON TABLE movies IS 'Справочник фильмов.';
COMMENT ON COLUMN movies.id IS 'Идентификатор.';
COMMENT ON COLUMN movies.title IS 'Название.';
------------------------------------------------------------------------------------------------------------------------
------------------------------------------- Сеансы фильмов в кинозалах. ------------------------------------------------
CREATE TABLE IF NOT EXISTS sessions
(
    id UUID NOT NULL,
    movie_id UUID NOT NULL,
    hall_id UUID NOT NULL,
    price INTEGER NOT NULL,
    start_date_at DATE DEFAULT NULL,
    start_time_at TIME WITHOUT TIME ZONE DEFAULT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_sessions_movies
        FOREIGN KEY (movie_id) REFERENCES movies
            DEFERRABLE,
    CONSTRAINT fk_sessions_halls
        FOREIGN KEY (hall_id) REFERENCES halls
            DEFERRABLE
);
COMMENT ON TABLE sessions IS 'Сеансы фильмов в кинозалах.';
COMMENT ON COLUMN sessions.id IS 'Идентификатор.';
COMMENT ON COLUMN sessions.movie_id IS 'Идентификатор фильма.';
COMMENT ON COLUMN sessions.hall_id IS 'Идентификатор кинозала.';
COMMENT ON COLUMN sessions.price IS 'Цена на сеанс.';
COMMENT ON COLUMN sessions.start_date_at IS 'Дата начала.';
COMMENT ON COLUMN sessions.start_time_at IS 'Время начала.';
CREATE INDEX IF NOT EXISTS idx_sessions_movies ON sessions USING btree(movie_id);
CREATE INDEX IF NOT EXISTS idx_sessions_halls ON sessions USING btree(hall_id);
CREATE INDEX IF NOT EXISTS idx_sessions_start_at ON sessions USING btree(start_date_at, start_time_at);
------------------------------------------------------------------------------------------------------------------------
------------------------------------------- Билеты в кино. -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS tickets
(
    id UUID NOT NULL,
    session_id UUID NOT NULL,
    hall_place_id UUID NOT NULL,
    price INTEGER,
    payment_at DATE,
    PRIMARY KEY (id),
    CONSTRAINT fk_tickets_sessions
        FOREIGN KEY (session_id) REFERENCES sessions
            DEFERRABLE,
    CONSTRAINT fk_tickets_halls_places
        FOREIGN KEY (hall_place_id) REFERENCES halls_places
            DEFERRABLE
);
COMMENT ON TABLE tickets IS 'Билеты в кино.';
COMMENT ON COLUMN tickets.id IS 'Идентификатор.';
COMMENT ON COLUMN tickets.session_id IS 'Идентификатор сеанса.';
COMMENT ON COLUMN tickets.hall_place_id IS 'Идентификатор места.';
COMMENT ON COLUMN tickets.price IS 'Стоимость.';
COMMENT ON COLUMN tickets.payment_at IS 'Дата платежа.';
CREATE INDEX IF NOT EXISTS idx_tickets_sessions ON tickets USING btree(session_id);
CREATE INDEX IF NOT EXISTS idx_tickets_halls_places ON tickets USING btree(hall_place_id);
CREATE INDEX IF NOT EXISTS idx_tickets_payment_at ON tickets USING btree(payment_at);

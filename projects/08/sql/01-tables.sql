-- Справочник фильмов. --
CREATE TABLE movies
(
    id SERIAL NOT NULL,
    title VARCHAR(255) NOT NULL CHECK (title != ''),
    PRIMARY KEY(id)
);
COMMENT ON TABLE movies IS 'Справочник фильмов.';
COMMENT ON COLUMN movies.id IS 'Идентификатор.';
COMMENT ON COLUMN movies.title IS 'Название.';

-- Кинозалы. --
CREATE TABLE halls
(
    id SERIAL NOT NULL,
    title VARCHAR(255) NOT NULL,
    PRIMARY KEY(id)
);
CREATE UNIQUE INDEX unique_idx_hall_title ON halls (title);

COMMENT ON TABLE halls IS 'Кинозалы.';
COMMENT ON COLUMN halls.id IS 'Идентификатор.';
COMMENT ON COLUMN halls.title IS 'Название.';

-- Места в кинозалах. --
CREATE TABLE halls_places
(
    id SERIAL NOT NULL,
    hall_id SMALLINT NOT NULL,
    row SMALLINT NOT NULL CHECK (row > 0),
    place SMALLINT NOT NULL CHECK (place > 0),
    PRIMARY KEY(id),
    CONSTRAINT fk_halls_places_hall_id
        FOREIGN KEY(hall_id)
            REFERENCES halls(id)
            DEFERRABLE INITIALLY IMMEDIATE
);
CREATE UNIQUE INDEX unique_idx_hall_place ON halls_places (hall_id, row, place);

COMMENT ON TABLE halls_places IS 'Места в зале.';
COMMENT ON COLUMN halls_places.id IS 'Идентификатор.';
COMMENT ON COLUMN halls_places.hall_id IS 'Идентификатор зала.';
COMMENT ON COLUMN halls_places.row IS 'Ряд.';
COMMENT ON COLUMN halls_places.place IS 'Номер места.';

-- Сеансы фильмов в кинозалах. --
CREATE TABLE sessions
(
    id SERIAL NOT NULL,
    movie_id SMALLINT NOT NULL,
    hall_id SMALLINT NOT NULL,
    start_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
    price INT NOT NULL,
    PRIMARY KEY(id),
    CONSTRAINT fk_session_movie_id
        FOREIGN KEY(movie_id)
            REFERENCES movies(id)
            DEFERRABLE INITIALLY IMMEDIATE,
    CONSTRAINT fk_session_hall_id
        FOREIGN KEY(hall_id)
            REFERENCES halls(id)
            DEFERRABLE INITIALLY IMMEDIATE
);
COMMENT ON TABLE sessions IS 'Сеансы фильмов в кинозалах.';
COMMENT ON COLUMN sessions.id IS 'Идентификатор.';
COMMENT ON COLUMN sessions.movie_id IS 'Идентификатор фильма.';
COMMENT ON COLUMN sessions.hall_id IS 'Идентификатор кинозала.';
COMMENT ON COLUMN sessions.start_at IS 'Дата и время начала.';
COMMENT ON COLUMN sessions.price IS 'Цена на сеанс.';

-- Билеты в кино. --
CREATE TABLE tickets
(
    id SERIAL NOT NULL,
    session_id INT NOT NULL,
    hall_place_id INT NOT NULL,
    price INT,
    PRIMARY KEY(id),
    CONSTRAINT fk_ticket_session_id
        FOREIGN KEY(session_id)
            REFERENCES sessions(id)
            DEFERRABLE INITIALLY IMMEDIATE,
    CONSTRAINT fk_ticket_hall_place_id
        FOREIGN KEY(hall_place_id)
            REFERENCES halls_places(id)
            DEFERRABLE INITIALLY IMMEDIATE
);

COMMENT ON TABLE tickets IS 'Билеты в кино.';
COMMENT ON COLUMN tickets.id IS 'Идентификатор.';
COMMENT ON COLUMN tickets.session_id IS 'Идентификатор сеанса.';
COMMENT ON COLUMN tickets.hall_place_id IS 'Идентификатор места.';
COMMENT ON COLUMN tickets.price IS 'Стоимость.';

CREATE TABLE events
(
    id UUID DEFAULT uuid_generate_v4(),
    name VARCHAR(255) NOT NULL,
    priority INT NOT NULL,
    PRIMARY KEY(id)
);
COMMENT ON TABLE events IS 'События.';
COMMENT ON COLUMN events.id IS 'Идентификатор.';
COMMENT ON COLUMN events.name IS 'Название.';
COMMENT ON COLUMN events.priority IS 'Приоритет.';

CREATE TABLE events_conditions
(
    id UUID DEFAULT uuid_generate_v4(),
    event_id UUID NOT NULL,
    name VARCHAR(255) NOT NULL,
    value INT NOT NULL,
    PRIMARY KEY(id),
    CONSTRAINT fk_events_conditions_event_id
        FOREIGN KEY(event_id)
            REFERENCES events(id)
            ON DELETE CASCADE
            DEFERRABLE INITIALLY IMMEDIATE
);
COMMENT ON TABLE events_conditions IS 'Условия событий.';
COMMENT ON COLUMN events_conditions.id IS 'Идентификатор.';
COMMENT ON COLUMN events_conditions.event_id IS 'Идентификатор события.';
COMMENT ON COLUMN events_conditions.name IS 'Название.';
COMMENT ON COLUMN events_conditions.value IS 'Значение.';

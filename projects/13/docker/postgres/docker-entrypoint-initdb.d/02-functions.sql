-- Добавить событие. --
CREATE OR REPLACE FUNCTION insert_event(
    e_name VARCHAR(255),
    e_priority INT
) RETURNS UUID AS $$
DECLARE
    e_id UUID;
BEGIN
    e_id = (SELECT id FROM events WHERE name = e_name);

    IF (e_id IS NULL) THEN
        INSERT INTO events (name, priority)
        VALUES (e_name, e_priority)
        RETURNING id INTO e_id;
    END IF;

    RETURN e_id;
END;
$$ LANGUAGE plpgsql;
COMMENT ON FUNCTION insert_event IS 'Создать событие.';


CREATE OR REPLACE FUNCTION insert_event_condition(
    e_id UUID,
    c_name VARCHAR(255),
    c_value INT
) RETURNS UUID AS $$
DECLARE
    c_id UUID;
BEGIN
    INSERT INTO events_conditions (event_id, name, value)
    VALUES (e_id, c_name, c_value)
    RETURNING id INTO c_id;

    RETURN c_id;
END
$$ LANGUAGE plpgsql;
COMMENT ON FUNCTION insert_event_condition IS 'Создать условие события.';


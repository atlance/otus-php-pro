DO
$$
DECLARE
    event_1_id UUID;
    event_2_id UUID;
    event_3_id UUID;
BEGIN

    -- События. --
    SELECT insert_event('Event 1', 1000) INTO event_1_id;
    SELECT insert_event('Event 2', 2000) INTO event_2_id;
    SELECT insert_event('Event 3', 3000) INTO event_3_id;

    -- Условия событий. --
    PERFORM insert_event_condition(event_1_id, 'param1', 1);

    PERFORM insert_event_condition(event_2_id, 'param1', 2);
    PERFORM insert_event_condition(event_2_id, 'param2', 2);

    PERFORM insert_event_condition(event_3_id, 'param1', 1);
    PERFORM insert_event_condition(event_3_id, 'param2', 2);

END;
$$ language plpgsql;

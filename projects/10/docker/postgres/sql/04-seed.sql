DO
$$
BEGIN
       PERFORM generate_all(
              100,
              10,
              30,
              30,
              CURRENT_DATE,
              (CURRENT_DATE + INTERVAL '45D'),
              INTERVAL '10H',
              INTERVAL '22H',
              INTERVAL '30m'
       );
END;
$$ language plpgsql;

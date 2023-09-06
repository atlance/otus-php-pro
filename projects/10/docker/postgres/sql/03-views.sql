CREATE OR REPLACE VIEW top_grossing_movies AS
SELECT m.id, m.title, sum(t.price) AS profit
FROM tickets AS t
    LEFT JOIN sessions AS s ON t.session_id = s.id
    LEFT JOIN movies AS m ON s.movie_id = m.id
WHERE t.price IS NOT NULL
GROUP BY m.id, m.title
ORDER BY profit DESC;
COMMENT ON VIEW top_grossing_movies IS 'Рейтинг кассовых фильмов.';

CREATE OR REPLACE VIEW today_movies AS
SELECT h.title AS hall, m.title AS title, s.start_time_at
FROM sessions AS s
    LEFT JOIN halls AS h ON h.id = s.hall_id
    LEFT JOIN movies AS m ON m.id = s.movie_id
WHERE s.start_date_at = CURRENT_DATE
ORDER BY h.title, s.start_time_at;
COMMENT ON VIEW today_movies IS 'Выбор всех фильмов на сегодня во всех кинозалах.';

CREATE OR REPLACE VIEW sold_week_tickets_count AS
SELECT COUNT(t.id)
FROM tickets AS t
WHERE t.payment_at::DATE >= CURRENT_DATE AND
      t.payment_at::DATE < CURRENT_DATE + 7;
COMMENT ON VIEW sold_week_tickets_count IS 'Количество проданных билетов за неделю.';

CREATE OR REPLACE VIEW profitable_movie_of_week AS
WITH src AS (SELECT id, movie_id FROM sessions WHERE start_date_at >= CURRENT_DATE AND start_date_at < CURRENT_DATE + 7)
SELECT m.id, m.title, sum(t.price) AS profit
FROM src
    LEFT JOIN tickets AS t ON t.session_id = src.id
    LEFT JOIN movies AS m ON m.id = src.movie_id
WHERE t.payment_at < NOW()
GROUP BY m.id, m.title
ORDER BY profit DESC;
COMMENT ON VIEW profitable_movie_of_week IS 'Самые прибыльные фильмы за неделю.';

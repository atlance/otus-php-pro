CREATE OR REPLACE VIEW top_grossing_movies AS
SELECT m.id, m.title, sum(t.price) AS profit
FROM tickets AS t
    LEFT JOIN sessions AS s ON t.session_id = s.id
    LEFT JOIN movies AS m ON s.movie_id = m.id
WHERE t.price IS NOT NULL
GROUP BY m.id, m.title
ORDER BY profit DESC;
COMMENT ON VIEW top_grossing_movies IS 'Рейтинг кассовых фильмов.';

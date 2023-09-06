-- Фильмы --
INSERT INTO movies (title)
VALUES ('Аватар'),
       ('Мстители: Финал'),
       ('Титаник'),
       ('Челюсти. Столкновение'),
       ('Выживший')
;

-- Залы --
INSERT INTO halls(title)
VALUES ('Основной'),
       ('Малый'),
       ('Большой');

-- Генерация мест в залах --
----------------------- 5 рядов по 4 места. ------------------------------
SELECT generate_places('Основной', 5, 4); --
--------------------------------------------------------------------------
----------------------- 3 ряда по 3 места. -------------------------------
SELECT generate_places('Малый', 3, 3); -----
--------------------------------------------------------------------------
----------------------- 6 рядов по 10 мест. ------------------------------
SELECT generate_places('Большой', 6, 10); --
--------------------------------------------------------------------------

-- Генерация сеансов в залах --
SELECT create_session('Титаник', 'Основной', '2023-01-01 12:00:00', 500); --

-- Генерация билетов и если нужно сеансов --
SELECT generate_tickets('Титаник', 'Основной', '2023-01-01 12:00:00', 500);
SELECT generate_tickets('Аватар', 'Малый', '2023-01-01 12:00:00', 300);
SELECT generate_tickets('Выживший', 'Большой', '2023-01-01 12:00:00', 200);
-----------------------------------------------------------------------------------------------------------------------

-- Купили билеты -------------------------------------------------------------------------
-- В "Основной" зал на фильм Титаник - 5 билетов x 500 = 2500 ----------------------------
SELECT buy_ticket('Титаник', 'Основной', 1, 2, '2023-01-01 12:00:00');
SELECT buy_ticket('Титаник', 'Основной', 1, 2, '2023-01-01 12:00:00');
SELECT buy_ticket('Титаник', 'Основной', 1, 3, '2023-01-01 12:00:00');
SELECT buy_ticket('Титаник', 'Основной', 1, 4, '2023-01-01 12:00:00');
SELECT buy_ticket('Титаник', 'Основной', 2, 1, '2023-01-01 12:00:00');
-- В "Малый" зал на фильм Аватар - 9 билетов x 300 = 2700 --------------------------------
SELECT buy_ticket('Аватар', 'Малый', 1, 1, '2023-01-01 12:00:00');
SELECT buy_ticket('Аватар', 'Малый', 1, 2, '2023-01-01 12:00:00');
SELECT buy_ticket('Аватар', 'Малый', 1, 3, '2023-01-01 12:00:00');
SELECT buy_ticket('Аватар', 'Малый', 2, 1, '2023-01-01 12:00:00');
SELECT buy_ticket('Аватар', 'Малый', 2, 2, '2023-01-01 12:00:00');
SELECT buy_ticket('Аватар', 'Малый', 2, 3, '2023-01-01 12:00:00');
SELECT buy_ticket('Аватар', 'Малый', 3, 1, '2023-01-01 12:00:00');
SELECT buy_ticket('Аватар', 'Малый', 3, 2, '2023-01-01 12:00:00');
SELECT buy_ticket('Аватар', 'Малый', 3, 3, '2023-01-01 12:00:00');
-- В "Большой" зал на фильм Выживший - (13 билетов x 200) + 1 билет за 50 = 2650 ---------------------------
SELECT buy_ticket('Выживший', 'Большой', 1, 1, '2023-01-01 12:00:00');
SELECT buy_ticket('Выживший', 'Большой', 1, 2, '2023-01-01 12:00:00');
SELECT buy_ticket('Выживший', 'Большой', 1, 3, '2023-01-01 12:00:00');
SELECT buy_ticket('Выживший', 'Большой', 1, 4, '2023-01-01 12:00:00');
SELECT buy_ticket('Выживший', 'Большой', 1, 5, '2023-01-01 12:00:00');
SELECT buy_ticket('Выживший', 'Большой', 1, 6, '2023-01-01 12:00:00');
SELECT buy_ticket('Выживший', 'Большой', 1, 7, '2023-01-01 12:00:00');
SELECT buy_ticket('Выживший', 'Большой', 1, 8, '2023-01-01 12:00:00');
SELECT buy_ticket('Выживший', 'Большой', 1, 9, '2023-01-01 12:00:00');
SELECT buy_ticket('Выживший', 'Большой', 1, 10, '2023-01-01 12:00:00');
SELECT buy_ticket('Выживший', 'Большой', 2, 1, '2023-01-01 12:00:00');
SELECT buy_ticket('Выживший', 'Большой', 2, 2, '2023-01-01 12:00:00');
SELECT buy_ticket('Выживший', 'Большой', 2, 3, '2023-01-01 12:00:00');
SELECT buy_ticket('Выживший', 'Большой', 2, 4, '2023-01-01 12:00:00', 50);
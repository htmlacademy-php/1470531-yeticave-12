USE yeticave;

/* password = 123456 */
INSERT INTO users (email, password, name, message)
VALUES ('mail1@mail.local', '$2y$10$aH5llwcVwmClhqSP2OqhLeHLDOlhO4VRXIBZMMxeBkySUwd8AE24G', 'Вася', '8900-000-00-00'),
       ('mail2@mail.local', '$2y$10$aH5llwcVwmClhqSP2OqhLeHLDOlhO4VRXIBZMMxeBkySUwd8AE24G', 'Петя', 'mail@mail.com');


INSERT INTO categories (title, symbol_code)
VALUES ('Доски и лыжи', 'boards'),
       ('Крепления', 'attachment'),
       ('Ботинкии', 'boots'),
       ('Одежда', 'clothing'),
       ('Инструменты', 'tools'),
       ('Разное', 'other');

INSERT INTO lots (title, description, image, starting_price, completion_date, bet_step, user_id, winner_id,
                  category_id)
VALUES ('2020 Super Snowboard',
        'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчком и четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
        'img/lot-1.jpg', 11000, '2021-01-02', 1000, 1,
        2, 1),
       ('2014 Rossignol District Snowboard',
        'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчком и четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
        'img/lot-1.jpg', 10999, '2021-02-15', 1000, 1,
        null, 1),
       ('DC Ply Mens 2016/2017 Snowboard',
        'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчком и четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
        'img/lot-2.jpg', 159999, '2021-02-15', 5000, 2,
        null, 1),
       ('Крепления Union Contact Pro 2015 года размер L/XL',
        'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчком и четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
        'img/lot-3.jpg', 500,
        '2021-03-20', 50, 1,
        null, 2),
       ('Ботинки для сноуборда DC Mutiny Charocal',
        'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчком и четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
        'img/lot-4.jpg', 10999, '2021-03-25',
        1000, 2,
        null, 3),
       ('Куртка для сноуборда DC Mutiny Charocal',
        'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчком и четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
        'img/lot-5.jpg', 7500, '2021-03-30', 500,
        1,
        null, 5),
       ('Маска Oakley Canopy',
        'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив снег мощным щелчком и четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла равнодушным.',
        'img/lot-6.jpg', 5400, '2021-04-05', 100, 1,
        null, 6);

INSERT INTO bets (created_on, price, lot_id, user_id) VALUES ('2021-01-01 15:00', 15000, 1, 2);

INSERT INTO bets (price, lot_id, user_id)
VALUES (11999, 4, 1),
       (12999, 4, 2);

# получить все категории;
SELECT *
FROM categories;

# получить самые новые, открытые лоты. Каждый лот должен включать название, стартовую цену, ссылку на изображение, текущую цену, название категории;
SELECT l.title                                title,
       l.starting_price                       starting_price,
       IFNULL(MAX(b.price), l.starting_price) current_price,
       l.image                                image,
       c.title                                category
FROM lots l
         JOIN categories c on c.id = l.category_id
         LEFT JOIN bets b on l.id = b.lot_id
WHERE l.completion_date > NOW()
GROUP BY l.title, l.starting_price, l.image, l.created_on, c.title
ORDER BY l.created_on DESC;

# показать лот по его id. Получите также название категории, к которой принадлежит лот;
SELECT l.title           title,
       c.title           category,
       l.image           image,
       l.starting_price  starting_price,
       l.completion_date completion_date,
       l.bet_step        bet_step
FROM lots l
         JOIN categories c on c.id = l.category_id
WHERE l.id = 3;

# обновить название лота по его идентификатору;
UPDATE lots
SET title = '2021 Rossignol District Snowboard'
WHERE id = 1;

# получить список ставок для лота по его идентификатору с сортировкой по дате.
SELECT b.id, b.created_on, b.price
FROM bets b
         JOIN lots l on l.id = b.lot_id
WHERE l.id = 4
ORDER BY created_on;

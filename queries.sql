USE yeticave;

INSERT INTO users (created_on, email, password)
VALUES ('2020-12-09 08:00:00', 'mail1@mail.local', '123456'),
       ('2020-12-09 08:00:01', 'mail2@mail.local', '123456');


INSERT INTO categories (created_on, title, symbol_code)
VALUES ('2020-12-09 08:00:00', 'Доски и лыжи', 'boards'),
       ('2020-12-09 08:00:01', 'Крепления', 'attachment'),
       ('2020-12-09 08:00:02', 'Ботинкии', 'boots'),
       ('2020-12-09 08:00:03', 'Одежда', 'clothing'),
       ('2020-12-09 08:00:04', 'Инструменты', 'tools'),
       ('2020-12-09 08:00:05', 'Разное', 'other');

INSERT INTO lots (created_on, title, description, image, starting_price, completion_date, bet_step, user_id, winner_id,
                  category_id)
VALUES ('2020-11-09 08:00:00', '2014 Rossignol District Snowboard', '', 'img/lot-1.jpg', 10999, '2020-12-08', 1000, 1,
        null, 1),
       ('2020-12-09 08:00:01', 'DC Ply Mens 2016/2017 Snowboard', '', 'img/lot-2.jpg', 159999, '2020-12-15', 5000, 2,
        null, 1),
       ('2020-12-09 08:00:02', 'Крепления Union Contact Pro 2015 года размер L/XL', '', 'img/lot-3.jpg', 500,
        '2020-12-20', 50, 1,
        null, 2),
       ('2020-12-09 08:00:03', 'Ботинки для сноуборда DC Mutiny Charocal', '', 'img/lot-4.jpg', 10999, '2020-12-25',
        1000, 2,
        null, 3),
       ('2020-12-09 08:00:04', 'Куртка для сноуборда DC Mutiny Charocal', '', 'img/lot-5.jpg', 7500, '2020-12-30', 500,
        1,
        null, 5),
       ('2020-12-09 08:00:05', 'Маска Oakley Canopy', '', 'img/lot-6.jpg', 5400, '2021-01-05', 100, 1,
        null, 6);

INSERT INTO bets (created_on, price, lot_id, user_id)
VALUES ('2020-12-09 09:00:00', 11999, 4, 1),
       ('2020-12-09 10:00:00', 12999, 4, 2);

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

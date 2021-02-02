<?php

define('SECONDS_IN_ONE_MINUTE', 3600);
define('MINUTES_IN_ONE_HOUR', 60);

/**
 * Проверяет переданную дату на соответствие формату 'ГГГГ-ММ-ДД'
 *
 * Примеры использования:
 * is_date_valid('2019-01-01'); // true
 * is_date_valid('2016-02-29'); // true
 * is_date_valid('2019-04-31'); // false
 * is_date_valid('10.10.2010'); // false
 * is_date_valid('10/10/2010'); // false
 *
 * @param string $date Дата в виде строки
 *
 * @return bool true при совпадении с форматом 'ГГГГ-ММ-ДД', иначе false
 */
function is_date_valid(string $date) : bool {
    $format_to_check = 'Y-m-d';
    $dateTimeObj = date_create_from_format($format_to_check, $date);

    return $dateTimeObj !== false && array_sum(date_get_last_errors()) === 0;
}

/**
 * Возвращает оставшееся количество часов и минут до переданной даты
 * @param string $date дата в формате 'ГГГГ-ММ-ДД'
 * @return array массив вида [ЧЧ, ММ]
 */
function getRemainingTime(string $date): array
{
    $current_timestamp = time();
    $end_timestamp = strtotime($date);

    $remaining_seconds = $end_timestamp - $current_timestamp;

    $hours = str_pad(floor($remaining_seconds / SECONDS_IN_ONE_MINUTE), 2, "0", STR_PAD_LEFT);
    $minutes = str_pad(floor(($remaining_seconds % SECONDS_IN_ONE_MINUTE) / MINUTES_IN_ONE_HOUR), 2, "0", STR_PAD_LEFT);

    return [$hours, $minutes];
}

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {
        $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
        die($errorMsg);
    }

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = 's';

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);

        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
            die($errorMsg);
        }
    }

    return $stmt;
}

/**
 * Возвращает корректную форму множественного числа
 * Ограничения: только для целых чисел
 *
 * Пример использования:
 * $remaining_minutes = 5;
 * echo "Я поставил таймер на {$remaining_minutes} " .
 *     get_noun_plural_form(
 *         $remaining_minutes,
 *         'минута',
 *         'минуты',
 *         'минут'
 *     );
 * Результат: "Я поставил таймер на 5 минут"
 *
 * @param int $number Число, по которому вычисляем форму множественного числа
 * @param string $one Форма единственного числа: яблоко, час, минута
 * @param string $two Форма множественного числа для 2, 3, 4: яблока, часа, минуты
 * @param string $many Форма множественного числа для остальных чисел
 *
 * @return string Рассчитанная форма множественнго числа
 */
function get_noun_plural_form (int $number, string $one, string $two, string $many): string
{
    $number = (int) $number;
    $mod10 = $number % 10;
    $mod100 = $number % 100;

    switch (true) {
        case ($mod100 >= 11 && $mod100 <= 20):
            return $many;

        case ($mod10 > 5):
            return $many;

        case ($mod10 === 1):
            return $one;

        case ($mod10 >= 2 && $mod10 <= 4):
            return $two;

        default:
            return $many;
    }
}

/**
 * Возвращает дату в "человеческом формате"
 *
 * @param string $timestamp
 * @return string
 */
function time_ago(string $timestamp): string
{
    $years = floor($timestamp / 31536000);
    $days = floor(($timestamp - ($years * 31536000)) / 86400);
    $hours = floor(($timestamp - ($years * 31536000 + $days * 86400)) / 3600);
    $minutes = floor(($timestamp - ($years * 31536000 + $days * 86400 + $hours * 3600)) / 60);
    $timestring = '';

    if ($timestamp < 60) {
        $timestring .= 'менее минуты ';
    }
    if ($years > 0) {
        $timestring .= $years . ' ' . get_noun_plural_form($years, 'год', 'года', 'лет') . ' ';
    }
    if ($days > 0) {
        $timestring .= $days . ' ' . get_noun_plural_form($days, 'день', 'дня', 'дней') . ' ';
    }
    if ($hours > 0) {
        $timestring .= $hours . ' ' . get_noun_plural_form($days, 'час', 'часа', 'часов') . ' ';
    }
    if ($minutes > 0) {
        $timestring .= $minutes . ' ' . get_noun_plural_form($days, 'мин.', 'мин.', 'мин.') . ' ';
    }

    $timestring .= 'назад';

    return $timestring;
}

/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
 * @param string $name Путь к файлу шаблона относительно папки templates
 * @param array $data Ассоциативный массив с данными для шаблона
 * @return string Итоговый HTML
 */
function include_template($name, array $data = []) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

/**
 * Форматирует число. Отделяет пробелом тысячные части и добавляет символ рубля
 *
 * @param float $price Цена товара
 * @return string Цена товара с символом рубля
 */
function format_price(float $price): string
{
    $rounded_price = ceil($price);

    if ($rounded_price < 1000) {
        return $rounded_price;
    }

    return number_format($rounded_price, 0, '', ' ') . ' ₽';
}

/**
 * Принимает ресурс соединения mysqli, возвращает массив категорий или пустой массив
 *
 * @param mysqli $sql_resource ресурс соедниения
 * @return array возвращаемый массив категорий
 */
function getCategories(mysqli $sql_resource): array
{
    $query = "SELECT `id`, `title`, `symbol_code` FROM categories;";
    $res = mysqli_query($sql_resource, $query);

    if ($res) {
        return mysqli_fetch_all($res, MYSQLI_ASSOC);
    }

    return [];
}

/**
 * Принимает ресурс соединения mysqli, возвращает массив объявлений или пустой массив
 *
 * @param mysqli $sql_resource ресурс соедниения
 * @return array возвращаемый массив объявлений
 */
function getOffers(mysqli $sql_resource): array
{
    $query = "   SELECT l.title                                title,
                           l.id                                   id,
                           l.description                          description,
                           l.starting_price                       starting_price,
                           IFNULL(MAX(b.price), l.starting_price) current_price,
                           l.image                                image,
                           l.completion_date                      completion_date,
                           c.title                                category
                    FROM lots l
                             JOIN categories c on c.id = l.category_id
                             LEFT JOIN bets b on l.id = b.lot_id
                    WHERE l.completion_date > NOW()
                    GROUP BY l.title, l.starting_price, l.image, l.created_on, c.title, l.completion_date, l.id, l.description
                    ORDER BY l.created_on DESC";
    $res = mysqli_query($sql_resource, $query);

    if ($res) {
        return mysqli_fetch_all($res, MYSQLI_ASSOC);
    }

    return [];
}

/**
 * Создает оффер из переданного массива с данными
 *
 * @param mysqli $sql_resource
 * @param array $data - ассоциативный массив с данными
 * @return bool - возвращает true если операция успешна
 */
function createOffer(mysqli $sql_resource, array $data): bool
{
    $offer_data = [
        $data['title'], $data['description'], $data['image'], $data['starting_price'], $data['completion_date'], $data['bet_step'], $data['category_id']
    ];
    $query = "INSERT INTO lots (title, description, image, starting_price, completion_date, bet_step, user_id, category_id)
                VALUES (?, ?, ?, ?, ?, ?, 1, ?);";
    $stmt = db_get_prepare_stmt($sql_resource, $query, $offer_data);

    return mysqli_stmt_execute($stmt);
}

/**
 * Принимает ресурс соединения mysqli и id лота, возвращает массив объявлений или пустой массив
 *
 * @param mysqli $sql_resource ресурс соедниения
 * @param int $id id лота
 * @return array возвращаемый ассоциативный массив объявлений
 */
function getOfferById(mysqli $sql_resource, int $id): array
{
    $query = "SELECT l.title                                title,
       l.created_on,
       l.id                                   id,
       l.description                          description,
       l.starting_price                       starting_price,
       IFNULL(MAX(b.price), l.starting_price) current_price,
       l.image                                image,
       l.completion_date                      completion_date,
       l.bet_step                             bet_step,
       c.title                                category
FROM lots l
         JOIN categories c on c.id = l.category_id
         LEFT JOIN bets b on l.id = b.lot_id
WHERE l.id = $id
GROUP BY l.id;";
    $res = mysqli_query($sql_resource, $query);
    $row_count = mysqli_num_rows($res);

    if ($row_count) {
        return mysqli_fetch_assoc($res);
    }

    return [];
}

/**
 * Перенаправляет на страницу 404
 */
function redirect_to_404(): void
{
    header("Location: 404.php");
    die();
}

/**
 * Проверяет, существует ли пользователь по переданному емейлу
 *
 * @param mysqli $sql_resource
 * @param string $email - email пользователя
 * @return bool
 */
function is_user_exist(mysqli $sql_resource, string $email): bool
{
    $data = ['email' => $email];
    $query = "SELECT id FROM users WHERE email = ?";
    $stmt = db_get_prepare_stmt($sql_resource, $query, $data);

    mysqli_stmt_execute($stmt);

    $res = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($res) > 0) {
        return true;
    }

    return false;
}

/**
 * Получает данные пользователя по email
 *
 * @param mysqli $sql_resource
 * @param string $email - email пользователя
 * @return array
 */
function get_user(mysqli $sql_resource, string $email): array
{
    $data = ['email' => $email];
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = db_get_prepare_stmt($sql_resource, $query, $data);

    mysqli_stmt_execute($stmt);

    $res = mysqli_stmt_get_result($stmt);

    if ($res) {
        return mysqli_fetch_assoc($res);
    }

    return [];
}

/**
 * Создает пользователя
 *
 * @param mysqli $sql_resource
 * @param $data - массив с данными из формы регистрации [email, name, password, message]
 * @return bool
 */
function create_user(mysqli $sql_resource, $data): bool
{
    $query = "INSERT INTO users (email, name, password, message) VALUES (?, ?, ?, ?)";
    $stmt = db_get_prepare_stmt($sql_resource, $query, $data);

    return mysqli_stmt_execute($stmt);
}

/**
 * Возвращает расширение файла в зависимости от переданного mime type
 *
 * @param string $mime_type
 * @return string
 */
function get_extension(string $mime_type): string
{
    $extensions = array(
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
    );

    return $extensions[$mime_type];
}

/**
 * Возвращает количество найденных результатов поиска
 * @param mysqli $sql_resource
 * @param $data - выражение для поиска
 * @return int
 */
function count_search(mysqli $sql_resource, string $data): int
{
    $sql = "SELECT COUNT(*) count
            FROM lots
            WHERE completion_date > NOW()
              AND MATCH(title, description) AGAINST(?);";
    $stmt = db_get_prepare_stmt($sql_resource, $sql, [$data]);

    mysqli_stmt_execute($stmt);

    $res = mysqli_stmt_get_result($stmt);

    if ($res) {
        return mysqli_fetch_assoc($res)['count'];
    }

    return 0;
}

/**
 * Возвращает количество найденных офферов для выбранной категории
 * @param mysqli $sql_resource
 * @param int $category_id - категории
 * @return int
 */
function count_offers_in_category(mysqli $sql_resource, int $category_id): int
{
    $sql = "SELECT COUNT(*) count
            FROM lots
            WHERE completion_date > NOW()
              AND category_id = ?;";
    $stmt = db_get_prepare_stmt($sql_resource, $sql, [$category_id]);

    mysqli_stmt_execute($stmt);

    $res = mysqli_stmt_get_result($stmt);

    if ($res) {
        return mysqli_fetch_assoc($res)['count'];
    }

    return 0;
}

/**
 * Возвращает результаты поиска в виде массива
 * @param mysqli $sql_resource
 * @param string $data - выражение для поиска
 * @param int $limit - максимальное количество результатов в итоговом массиве
 * @param int $offset - сдвиг
 * @return array
 */
function make_search(mysqli $sql_resource, string $data, int $limit, int $offset): array
{
    $sql = "SELECT l.title,
                   l.id,
                   l.description,
                   l.starting_price,
                   IFNULL(MAX(b.price), l.starting_price) current_price,
                   l.image,
                   l.completion_date,
                   c.title                                category
            FROM lots l
                     JOIN categories c on c.id = l.category_id
                     LEFT JOIN bets b on l.id = b.lot_id
            WHERE l.completion_date > NOW()
              AND MATCH(l.title, l.description) AGAINST(?)
            GROUP BY l.title, l.starting_price, l.image, l.created_on, c.title, l.completion_date, l.id, l.description
            ORDER BY l.created_on DESC
            LIMIT ? OFFSET ?;";
    $stmt = db_get_prepare_stmt($sql_resource, $sql, [$data, $limit, $offset]);

    mysqli_stmt_execute($stmt);

    $res = mysqli_stmt_get_result($stmt);

    if ($res) {
        return mysqli_fetch_all($res, MYSQLI_ASSOC);
    }

    return [];
}

/**
 * Создает ставку
 *
 * @param mysqli $sql_resource
 * @param int $bet - ставка
 * @param int $offer_id - id оффера
 * @param int $user_id - id польователя
 * @return bool
 */
function make_bet(mysqli $sql_resource, int $bet, int $offer_id, int $user_id): bool
{
    $query = "INSERT INTO bets (price, lot_id, user_id) VALUES (?, ?, ?)";
    $stmt = db_get_prepare_stmt($sql_resource, $query, [$bet, $offer_id, $user_id]);

    return mysqli_stmt_execute($stmt);
}

/**
 * Возвращает массив ставок для лота
 *
 * @param mysqli $sql_resource
 * @param int $lot_id - id лота
 * @return array
 */
function get_bets(mysqli $sql_resource, int $lot_id): array
{
    $query = "  SELECT u.name, u.id, price, b.created_on
                FROM bets b
                         LEFT JOIN users u on b.user_id = u.id
                WHERE lot_id = $lot_id
                ORDER BY created_on DESC;";

    $res = mysqli_query($sql_resource, $query);

    if ($res) {
        return mysqli_fetch_all($res, MYSQLI_ASSOC);
    }

    return [];
}

/**
 * Возвращает все ставки пользователя
 *
 * @param mysqli $sql_resource
 * @param int $user_id - id пользователя
 * @return array
 */
function get_my_bets(mysqli $sql_resource, int $user_id):array
{
    $query = "
SELECT u.name,
       (SELECT message FROM users WHERE l.user_id = users.id) contact,
       price,
       b.created_on,
       l.title,
       l.image,
       l.completion_date,
       l.id,
       c.title                                                         category,
       l.winner_id
FROM bets b
         LEFT JOIN users u on b.user_id = u.id
         LEFT JOIN lots l on l.id = b.lot_id
         LEFT JOIN categories c on l.category_id = c.id
WHERE b.user_id = $user_id
ORDER BY created_on DESC;";

    $res = mysqli_query($sql_resource, $query);

    if ($res) {
        return mysqli_fetch_all($res, MYSQLI_ASSOC);
    }

    return [];
}

/**
 * Возвращет текст ошибки для переданного кода ошибки
 *
 * @param string $error - текстовый код ошибки
 * @return string
 */
function get_bet_error_text(string $error):string {
    switch ($error) {
        case 'empty':
            return 'Введите ставку';
        case 'not_num':
            return 'Введите число';
        case 'low':
            return 'Ставка меньше минимальной';
        default:
            return '';
    }
}

/**
 * Возвращает массив лотов в зависимости от категории
 *
 * @param mysqli $sql_resource
 * @param int $category_id
 * @param int $limit
 * @param int $offset
 * @return array
 */
function get_lots_by_category(mysqli $sql_resource, int $category_id, int $limit, int $offset): array
{
    $sql = "SELECT l.title,
                   l.id,
                   l.description,
                   l.starting_price,
                   IFNULL(MAX(b.price), l.starting_price) current_price,
                   l.image,
                   l.completion_date,
                   c.title                                category
            FROM lots l
                     JOIN categories c on c.id = l.category_id
                     LEFT JOIN bets b on l.id = b.lot_id
            WHERE l.completion_date > NOW()
              AND l.category_id = ?
            GROUP BY l.title, l.starting_price, l.image, l.created_on, c.title, l.completion_date, l.id, l.description
            ORDER BY l.created_on DESC
            LIMIT ? OFFSET ?;";
    $stmt = db_get_prepare_stmt($sql_resource, $sql, [$category_id, $limit, $offset]);

    mysqli_stmt_execute($stmt);

    $res = mysqli_stmt_get_result($stmt);

    if ($res) {
        return mysqli_fetch_all($res, MYSQLI_ASSOC);
    }

    return [];
}

/**
 * Возвращает html разметку для списка категорий
 *
 * @param array $categories
 * @return string
 */
function render_categories(array $categories): string
{
    $result = '';

    foreach ($categories as $category) {
        $title = htmlspecialchars($category['title']);
        $result .= "<li class='nav__item'>
                    <a href='./lots.php?category=$category[id]''>$title</a>
                </li>";
    }

    return $result;
}

<?php
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
    define('SECONDS_IN_ONE_MINUTE', 3600);
    define('MINUTES_IN_ONE_HOUR', 60);

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
 * Принимает ресурс соединения mysqli и id лота, возвращает массив объявлений или пустой массив
 *
 * @param mysqli $sql_resource ресурс соедниения
 * @param int $id id лота
 * @return array возвращаемый ассоциативный массив объявлений
 */
function getOfferById(mysqli $sql_resource, int $id): array
{
    $query = "SELECT l.title                                title,
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

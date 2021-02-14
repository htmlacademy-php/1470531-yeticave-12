<?php

/**
 * Проверка значения выбранной категории
 *
 * @param  int   $category_id - id
 *                            категории
 * @param  array $categories  - массив
 *                            категорий
 * @return string|null
 */
function check_category(int $category_id, array $categories): ?string
{
    if (empty($category_id)) {
        return 'Выберите категорию';
    } else {
        if ($category_id < 0 || $category_id > (count($categories) - 1)) {
            return 'Категория не найдена';
        }
    }

    return null;
}

/**
 * Проверка поля с целым числом
 *
 * @param  int $number - целое число
 * @return string|null
 */
function check_number(int $number): ?string
{
    if (empty($number)) {
        return 'Заполните это поле';
    }

    if (!$number || $number < 1) {
        return 'Введите положительное число';
    }

    return null;
}

/**
 * Проверка загрузки изображения
 *
 * @param  array $file - файл из массива $_FILES
 * @return string|null
 */
function check_image(array $file): ?string
{
    $allowed_image_types = ['image/png', 'image/jpeg'];
    $is_empty_file_field = $file && $file['size'] === 0;
    $is_wrong_image_type = !$is_empty_file_field && !in_array($file['type'], $allowed_image_types, true);

    if ($is_empty_file_field) {
        return 'Загрузите изображение';
    } else {
        if ($is_wrong_image_type) {
            return 'Изображение должно быть в формате jpg или png';
        }
    }

    return null;
}

/**
 * Проверка текстового поля
 *
 * @param  string $text - текст для проверки
 * @return string|null
 */
function check_text(string $text): ?string
{
    if (empty($text)) {
        return 'Заполните это поле';
    }

    return null;
}

/**
 * Проверка введенной даты
 *
 * @param  string $date - дата в формате ГГГГ-ММ-ДД
 * @return string|null
 */
function check_date(string $date): ?string
{
    if (empty($date)) {
        return 'Заполните это поле';
    }

    if (!$date
        || !is_date_valid($date)
        || intval(getRemainingTime($date)['0']) < 24
    ) {
        return 'Введите корректную дату';
    }

    return null;
}

/**
 * Проверка введенного email
 *
 * @param  string $email
 * @return string|null
 */
function check_email(string $email): ?string
{
    if (empty($email)) {
        return 'Заполните это поле';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'Введите правильный емейл адрес';
    }

    return null;
}

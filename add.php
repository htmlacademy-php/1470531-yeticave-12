<?php

include_once 'helpers.php';
include_once 'config.php';

$categories = getCategories($mysql);
$page_content;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST;
    $file = $_FILES['image'];
    $required = ['title', 'description', 'starting_price', 'completion_date', 'bet_step'];
    $allowed_image_types = ['image/png', 'image/jpeg'];
    $errors = [];
    $starting_price = intval($_POST['starting_price'] ?? null);
    $bet_step = intval($_POST['bet_step'] ?? null);
    $completion_date = mysqli_real_escape_string($mysql, $_POST['completion_date'] ?? null);
    $is_empty_file_field = $file && $file['size'] == 0;
    $is_wrong_image_type = !$is_empty_file_field && !in_array($file['type'], $allowed_image_types, true);

    foreach ($required as $field) {
        if (empty($form[$field])) {
            $errors[$field] = 'Заполните это поле';
        }
    }

    if ($is_empty_file_field) {
        $errors['image'] = 'Загрузите изображение';
    } else {
        if ($is_wrong_image_type) {
            $errors['image'] = 'Изображение должно быть в формате jpg или png';
        }
    }

    if (!$starting_price || intval($starting_price) < 1) {
        $errors['starting_price'] = 'Введите положительное число';
    }

    if (!$bet_step || intval($bet_step) < 1 || strpos('.', $bet_step) || strpos(',', $bet_step)) {
        $errors['bet_step'] = 'Введите положительное целое число';
    }

    if (empty($form['category_id'])) {
        $errors['category_id'] = 'Выберите категорию';
    }

    if (
        !$completion_date
        || !is_date_valid($completion_date)
        || intval(getRemainingTime($completion_date)['0']) < 24
    ) {
        $errors['completion_date'] = 'Введите корректную дату';
    }

    if (count($errors)) {
        $page_content = include_template('add.php', [
            'categories' => $categories,
            'form' => $form,
            'errors' => $errors
        ]);
    } else {
        $file_name = uniqid() . '.' . get_extension($file['type']);
        $form['image'] = $file_name;

        move_uploaded_file($file['tmp_name'], SITE_ROOT . '/uploads/' . $file_name);

        $res = createOffer($mysql, $form);

        if ($res) {
            $new_id = mysqli_insert_id($mysql);

            header("Location: ./lot.php?id=$new_id");
            exit();
        }
    }
} else {
    $page_content = include_template('add.php', [
        'categories' => $categories,
        'errors' => [],
        'form' => []
    ]);
}

$layout_content = include_template('layout.php', [
    'title' => 'Добавление лота',
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'content' => $page_content,
    'categories' => $categories,
]);

print($layout_content);

?>

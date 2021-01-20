<?php

include_once 'helpers.php';
include_once 'form-validators.php';
include_once 'config.php';

$categories = getCategories($mysql);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form = $_POST;
    $file = $_FILES['image'];
    $errors = [];
    $starting_price = intval($_POST['starting_price'] ?? null);
    $bet_step = intval($_POST['bet_step'] ?? null);
    $completion_date = mysqli_real_escape_string($mysql, $_POST['completion_date'] ?? null);
    $errors['title'] = check_text($form['title']);
    $errors['description'] = check_text($form['description']);
    $errors['image'] = check_image($file);
    $errors['starting_price'] = check_number($starting_price);
    $errors['bet_step'] = check_number($bet_step);
    $errors['category_id'] = check_category($form['category_id'], $categories);
    $errors['completion_date'] = check_date($completion_date);

    if (count(array_filter($errors))) {
        $page_content = include_template('add.php', [
            'categories' => $categories,
            'form' => $form,
            'errors' => $errors
        ]);
    } else {
        $file_name = uniqid() . '.' . get_extension($file['type']);
        $form['image'] = $file_name;
        $move_image_res = move_uploaded_file($file['tmp_name'], SITE_ROOT . '/uploads/' . $file_name);

        if (!$move_image_res) {
            $errors['image'] = 'Ошибка загрузки изображения';
        }

        $create_offer_res = createOffer($mysql, $form);

        if (!$create_offer_res) {
            $errors['title'] = 'Ошибка создания лота';
        }

        $new_id = mysqli_insert_id($mysql);

        if (count(array_filter($errors))) {
            $page_content = include_template('add.php', [
                'categories' => $categories,
                'errors' => $errors,
                'form' => []
            ]);
        } else {
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

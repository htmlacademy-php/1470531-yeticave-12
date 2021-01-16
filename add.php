<?php

include_once 'helpers.php';
include_once 'form-validators.php';
include_once 'config.php';

$categories = getCategories($mysql);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form = $_POST;
    $file = $_FILES['image'];
    $required = ['title', 'description', 'starting_price', 'completion_date', 'bet_step'];
    $errors = [];
    $starting_price = intval($_POST['starting_price'] ?? null);
    $bet_step = intval($_POST['bet_step'] ?? null);
    $completion_date = mysqli_real_escape_string($mysql, $_POST['completion_date'] ?? null);

    foreach ($required as $field) {
        $errors[$field] = check_text($form[$field]);
    }

    $errors['image'] = check_image($file);
    $errors['starting_price'] = check_number($starting_price);
    $errors['bet_step'] = check_number($bet_step);
    $errors['category_id'] = check_category($form['category_id'], $categories);
    $errors['completion_date'] = check_date($completion_date);

//    var_dump($errors);die();

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

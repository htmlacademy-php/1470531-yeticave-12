<?php

include_once 'helpers.php';
include_once 'form-validators.php';
include_once 'config.php';

if (isset($_SESSION['user'])) {
    header("Location: ./");
    exit();
}

$categories = getCategories($mysql);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form = $_POST;
    $required = ['email', 'password', 'name', 'message'];
    $errors = [];
    $errors['email'] = check_email($form['email']);
    $errors['password'] = check_text($form['password']);
    $errors['name'] = check_text($form['name']);
    $errors['message'] = check_text($form['message']);

    if (count(array_filter($errors))) {
        $page_content = include_template('sign-up.php', [
            'categories' => $categories,
            'form' => $form,
            'errors' => $errors
        ]);
    } else {
        if (is_user_exist($mysql, $form['email'])) {
            $errors['email'] = 'Пользователь с этим email уже зарегистрирован';

            $page_content = include_template('sign-up.php', [
                'categories' => $categories,
                'form' => $form,
                'errors' => $errors
            ]);
        } else {
            $password = password_hash($form['password'], PASSWORD_DEFAULT);
            $data = [
                'email' => $form['email'],
                'name' => $form['name'],
                'password' => $password,
                'message' => $form['message']
            ];
            $create_user_res = create_user($mysql, $data);

            if (!$create_user_res) {
                header("Location: ./500.php");
                exit();
            } else {
                header("Location: ./login.php");
                exit();
            }
        }
    }
} else {
    $page_content = include_template('sign-up.php', [
        'categories' => $categories,
        'form' => [],
        'errors' => []
    ]);
}

$layout_content = include_template('layout.php', [
    'title' => "Регистрация",
    'isContainerClass' => false,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'content' => $page_content,
    'categories' => $categories,
]);

print($layout_content);

?>

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
    $errors = [];
    $errors['email'] = check_email($form['email']);
    $errors['password'] = check_text($form['password']);

    if (count(array_filter($errors))) {
        $page_content = get_auth_page_content('login', $categories, $form, $errors);
    } else if (!is_user_exist($mysql, $form['email'])) {
        $errors['email'] = 'Пользователь с этим email не зарегистрирован';
        $page_content = get_auth_page_content('login', $categories, $form, $errors);
    } else {
        $user = get_user($mysql, $form['email']);

        if (password_verify($form['password'], $user['password'])) {
            $_SESSION['user'] = $user;
            header("Location: ./index.php");
            exit();
        }

        $errors['password'] = 'Пароль неверный';
        $page_content = get_auth_page_content('login', $categories, $form, $errors);
    }
} else {
    if (isset($_SESSION['user'])) {
        header("Location: ./index.php");
        exit();
    }

    $page_content = get_auth_page_content('login', $categories, [], []);
}

$layout_content = include_template('layout.php', [
    'title' => "Вход",
    'isContainerClass' => false,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'content' => $page_content,
    'categories' => $categories,
]);

print($layout_content);

?>

<?php

include_once 'helpers.php';
include_once 'form-validators.php';
include_once 'config.php';

$categories = getCategories($mysql);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
        $email = mysqli_real_escape_string($mysql, $form['email']);

        if (is_user_exist($mysql, $email)) {
            $errors['email'] = 'Пользователь с этим email уже зарегистрирован';

            $page_content = include_template('sign-up.php', [
                'categories' => $categories,
                'form' => $form,
                'errors' => $errors
            ]);
        } else {
            $password = password_hash($form['password'], PASSWORD_DEFAULT);
            $name = mysqli_real_escape_string($mysql, $form['name']);
            $message = mysqli_real_escape_string($mysql, $form['message']);
            $data = ['email' => $email, 'name' => $name, 'password' => $password, 'message' => $message];

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
    'is_redirect_to_404' => false,
    'isContainerClass' => false,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'content' => $page_content,
    'categories' => $categories,
]);

print($layout_content);

?>

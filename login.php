<?php

include_once 'helpers.php';
include_once 'config.php';

$categories = getCategories($mysql);


$main_page_content = include_template('login.php', [
    'categories' => $categories,
]);

$layout_content = include_template('layout.php', [
    'title' => "Вход",
    'is_redirect_to_404' => false,
    'isContainerClass' => false,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'content' => $main_page_content,
    'categories' => $categories,
]);

print($layout_content);

?>

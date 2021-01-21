<?php

include_once 'helpers.php';
include_once 'config.php';

$categories = getCategories($mysql);

$main_page_content = include_template('500.php', [
    'categories' => $categories,
]);

$layout_content = include_template('layout.php', [
    'title' => 'Что то пошло не так',
    'isContainerClass' => false,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'content' => $main_page_content,
    'categories' => $categories,
]);

print($layout_content);

?>

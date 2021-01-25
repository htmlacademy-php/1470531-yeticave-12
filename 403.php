<?php

include_once 'helpers.php';
include_once 'config.php';

$categories = getCategories($mysql);

$main_page_content = include_template('403.php', [
    'categories' => $categories,
]);

$layout_content = include_template('layout.php', [
    'title' => 'Доступ запрещен',
    'isContainerClass' => false,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'content' => $main_page_content,
    'categories' => $categories,
]);

print($layout_content);

?>

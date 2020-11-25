<?php

include_once 'helpers.php';
include_once 'config.php';

$main_page_content = include_template('main.php', [
    'categories' => $categories,
    'offers' => $offers,
]);
$layout_content = include_template('layout.php', [
    'title' => $page_titles['main'],
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'content' => $main_page_content,
    'categories' => $categories,
]);

print($layout_content);

?>

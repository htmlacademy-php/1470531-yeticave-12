<?php

include_once 'helpers.php';
include_once 'config.php';

$categories = getCategories($mysql);
$offers = getOffers($mysql);


$main_page_content = include_template('main.php', [
    'categories' => $categories,
    'offers' => $offers,
]);

$layout_content = include_template('layout.php', [
    'title' => 'Главная',
    'isContainerClass' => true,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'content' => $main_page_content,
    'categories' => $categories,
]);

print($layout_content);

?>

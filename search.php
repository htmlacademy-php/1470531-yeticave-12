<?php

include_once 'helpers.php';
include_once 'config.php';

$categories = getCategories($mysql);
$search = $_GET['search'] ?? '';
$current_page = $_GET['page'] ?? 1;
$page_items = 10;

if ($search) {
    $items_count = count_search($mysql, $search);
    $pages_count = ceil($items_count / $page_items);
    $offset = ($current_page - 1) * $page_items;
    $pages = range(1, $pages_count);
    $offers = [];

    if ($items_count) {
        $offers = make_search($mysql, $search, $page_items, $offset);
    }

    $page_content = include_template('search.php', [
        'categories' => $categories,
        'search' => $search,
        'offers' => $offers,
        'pages_count' => $pages_count,
        'pages' => $pages,
        'current_page' => $current_page
    ]);
} else {
    $page_content = include_template('search.php', [
        'categories' => $categories,
        'search' => $search,
        'offers' => [],
        'pages_count' => 0,
        'pages' => [],
        'current_page' => $current_page
    ]);
}

$layout_content = include_template('layout.php', [
    'title' => 'Результаты поиска',
    'isContainerClass' => false,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'content' => $page_content,
    'categories' => $categories,
]);

print($layout_content);

?>

<?php

include_once 'helpers.php';
include_once 'config.php';

$categories = getCategories($mysql);
$search = $_GET['search'] ? trim($_GET['search']) : '';
$current_page = $_GET['page'] ?? 1;
$page_items = 9;

if ($search) {
    $items_count = count_search($mysql, $search);
    $pages_count = intval(ceil($items_count / $page_items));
    $offset = ($current_page - 1) * $page_items;
    $pages = range(1, $pages_count);
    $offers = [];

    if ($current_page > $pages_count || $current_page < 1) {
        redirect_to_404();
    }

    if ($items_count) {
        $offers = make_search($mysql, $search, $page_items, $offset);
    }

    $page_content = include_template('search.php', [
        'categories' => $categories,
        'search' => $search,
        'offers' => $offers,
        'isEmptySearch' => true,
        'pages_count' => $pages_count,
        'pages' => $pages,
        'current_page' => $current_page
    ]);
} else {
    $page_content = include_template('search.php', [
        'categories' => $categories,
        'search' => $search,
        'isEmptySearch' => true,
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



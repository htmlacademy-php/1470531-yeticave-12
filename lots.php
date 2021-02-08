<?php

include_once 'helpers.php';
include_once 'config.php';

$category_id = filter_input(INPUT_GET, 'category', FILTER_SANITIZE_NUMBER_INT);

if (!$category_id || intval($category_id) <= 0) {
    redirect_to_404();
}

$categories = getCategories($mysql);

if (!array_key_exists(intval($category_id), $categories)) {
    redirect_to_404();
}

$current_page = $_GET['page'] ?? 1;
$page_items = 9;
$items_count = count_offers_in_category($mysql, $category_id);
$pages_count = intval(ceil($items_count / $page_items));
$offset = ($current_page - 1) * $page_items;
$pages = range(1, $pages_count);
$offers = [];
$category_title = $categories[$category_id]['title'];

if ($items_count !== 0 && $current_page > $pages_count || $current_page < 1) {
    redirect_to_404();
}

if ($items_count) {
    $offers = get_lots_by_category($mysql, $category_id, $page_items, $offset);

    $page_content = include_template('lots.php', [
        'categories' => $categories,
        'offers' => $offers,
        'pages_count' => $pages_count,
        'pages' => $pages,
        'current_page' => $current_page,
        'category_title' => $category_title
    ]);
} else {
    $page_content = include_template('lots.php', [
        'categories' => $categories,
        'offers' => [],
        'pages_count' => $pages_count,
        'pages' => $pages,
        'current_page' => $current_page,
        'category_title' => $category_title
    ]);
}

$layout_content = include_template('layout.php', [
    'title' => 'Лоты в категории ' . $category_title,
    'isContainerClass' => false,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'content' => $page_content,
    'categories' => $categories,
]);

print($layout_content);

?>

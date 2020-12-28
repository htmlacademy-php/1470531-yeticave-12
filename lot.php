<?php

include_once 'helpers.php';
include_once 'config.php';

$categories = getCategories($mysql);
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!$id || $id < 0) {
    redirect_to_404();
}

$offer = getOfferById($mysql, $id);

if (!count($offer) || !$offer['id']) {
    redirect_to_404();
}

$page_content = include_template('lot.php', [
    'categories' => $categories,
    'offer' => $offer,
]);

$layout_content = include_template('layout.php', [
    'title' => $offer['title'],
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'content' => $page_content,
    'categories' => $categories,
]);

print($layout_content);

?>

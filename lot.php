<?php

include_once 'helpers.php';
include_once 'config.php';

$categories = getCategories($mysql);
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (strlen($id)) {
    $offer = getOfferById($mysql, $id);
}

if ($offer['id']) {
    $page_content = include_template('lot.php', [
        'categories' => $categories,
        'offer' => $offer,
    ]);
    $is_error = false;
} else {
    $page_content = '';
    $is_error = true;
}

if ($is_error) {
    redirect_to_404();
}


$layout_content = include_template('layout.php', [
    'title' => $offer['title'],
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'content' => $page_content,
    'categories' => $categories,
]);

print($layout_content);

?>

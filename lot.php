<?php

include_once 'helpers.php';
include_once 'config.php';

$categories = getCategories($mysql);
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$bet_error = isset($_GET['bet_error']) ? filter_input(INPUT_GET, 'bet_error', FILTER_SANITIZE_STRING) : '';

if (!$id || $id < 0) {
    redirect_to_404();
}

$offer = getOfferById($mysql, $id);

if (!count($offer)) {
    redirect_to_404();
}

$bets = get_bets($mysql, $id);
$is_lot_open = strtotime($offer['completion_date']) > time();
$my_id = $_SESSION['user']['id'];
$is_offer_from_me = intval($offer['id']) === $my_id;
$is_last_bet_from_me = $my_id === intval($bets[0]['id']);

$page_content = include_template('lot.php', [
    'categories' => $categories,
    'offer' => $offer,
    'is_bet_visible' => $is_auth && !$is_offer_from_me && $is_lot_open && !$is_last_bet_from_me,
    'bet_error' => get_bet_error_text($bet_error),
    'bets' => $bets
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

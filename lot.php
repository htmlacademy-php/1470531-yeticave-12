<?php

include_once 'helpers.php';
include_once 'config.php';

$categories = getCategories($mysql);
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if (!$id || $id < 0) {
    redirect_to_404();
}

$offer = getOfferById($mysql, $id);

if (!count($offer)) {
    redirect_to_404();
}

$bets = get_bets($mysql, $id);
$is_lot_open = strtotime($offer['completion_date']) > time();
$my_id = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;
$is_offer_from_me = intval($offer['id']) === $my_id;
$is_last_bet_from_me = count($bets) ? $my_id === intval($bets[0]['id']) : false;
$current_price = number_format($offer['current_price'], 0, '', ' ');
$minimal_bet = number_format($offer['bet_step'] + $offer['current_price'], 0, '', ' ');
$bet_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form = $_POST;
    $bet = intval($form['bet']);

    if ($id && !isset($form['bet'])) {
        redirect_to_404();
    } elseif (!strlen($form['bet'])) {
        $bet_error = 'empty';
    } elseif (!is_numeric($form['bet'])) {
        $bet_error = 'not_num';
    } elseif ($bet < ($offer['bet_step'] + $offer['current_price'])) {
        $bet_error = 'low';
    }

    if ($bet_error) {
        $page_content = include_template('lot.php', [
            'categories' => $categories,
            'offer' => $offer,
            'is_bet_visible' => $is_auth && !$is_offer_from_me && $is_lot_open && !$is_last_bet_from_me,
            'bets' => $bets,
            'bet_error' => get_bet_error_text($bet_error),
            'current_price' => $current_price,
            'minimal_bet' => $minimal_bet
        ]);
    } else {
        $res = make_bet($mysql, $bet, $id, $_SESSION['user']['id']);

        $res ? header("Location: ./lot.php?id=$id") : header("Location: ./500.php");
        exit();
    }
} else {
    $page_content = include_template('lot.php', [
        'categories' => $categories,
        'offer' => $offer,
        'is_bet_visible' => $is_auth && !$is_offer_from_me && $is_lot_open && !$is_last_bet_from_me,
        'bets' => $bets,
        'bet_error' => '',
        'current_price' => $current_price,
        'minimal_bet' => $minimal_bet
    ]);
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

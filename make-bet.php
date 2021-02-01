<?php

include_once 'helpers.php';
include_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $offer_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $minimal_bet = filter_input(INPUT_GET, 'min', FILTER_SANITIZE_NUMBER_INT);
    $form = $_POST;

    if ($offer_id && !isset($form['bet'])) {
        redirect_to_404();
    }

    if (!strlen($form['bet'])) {
        header("Location: ./lot.php?id=$offer_id&bet_error=empty");
        exit();
    }

    if (!is_numeric($form['bet'])) {
        header("Location: ./lot.php?id=$offer_id&bet_error=not_num");
        exit();
    }

    $bet = intval($form['bet']);

    if ($bet < $minimal_bet) {
        header("Location: ./lot.php?id=$offer_id&bet_error=low");
        exit();
    }

    $res = make_bet($mysql, $bet, $offer_id, $_SESSION['user']['id']);

    $res ? header("Location: ./lot.php?id=$offer_id") : header("Location: ./500.php");
    exit();

}

?>

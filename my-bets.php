<?php

include_once 'helpers.php';
include_once 'config.php';

if (!isset($_SESSION['user'])) {
    header("Location: ./login.php");
    exit();
}

$categories = getCategories($mysql);
$bets = get_my_bets($mysql, $_SESSION['user']['id']);

$page_content = include_template('my-bets.php', [
    'categories' => $categories,
    'bets' => $bets,
    'user_id' => $_SESSION['user']['id']
]);

$layout_content = include_template('layout.php', [
    'title' => 'Мои ставки',
    'isContainerClass' => false,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'content' => $page_content,
    'categories' => $categories,
]);

print($layout_content);

?>

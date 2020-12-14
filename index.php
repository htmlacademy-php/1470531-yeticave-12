<?php

include_once 'helpers.php';
include_once 'config.php';

$categories_query = "SELECT `id`, `title`, `symbol_code` FROM categories";
$offers_query .= "  SELECT l.title                                title,
                           l.starting_price                       starting_price,
                           IFNULL(MAX(b.price), l.starting_price) current_price,
                           l.image                                image,
                           l.completion_date                      completion_date,
                           c.title                                category
                    FROM lots l
                             JOIN categories c on c.id = l.category_id
                             LEFT JOIN bets b on l.id = b.lot_id
                    WHERE l.completion_date > NOW()
                    GROUP BY l.title, l.starting_price, l.image, l.created_on, c.title, l.completion_date
                    ORDER BY l.created_on DESC";
$categories_res = mysqli_query($mysql, $categories_query);
$offers_res = mysqli_query($mysql, $offers_query);


if ($categories_res) {
    $categories = mysqli_fetch_all($categories_res, MYSQLI_ASSOC);
}

if ($offers_res) {
    $offers = mysqli_fetch_all($offers_res, MYSQLI_ASSOC);
}

$main_page_content = include_template('main.php', [
    'categories' => $categories,
    'offers' => $offers,
]);
$layout_content = include_template('layout.php', [
    'title' => $page_titles['main'],
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'content' => $main_page_content,
    'categories' => $categories,
]);

print($layout_content);

?>

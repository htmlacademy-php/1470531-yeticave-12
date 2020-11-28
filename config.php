<?php
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');

$is_auth = rand(0, 1);

$user_name = 'Alexey'; // укажите здесь ваше имя

$categories = [
    [
        'name' => 'Доски и лыжи',
        'css_modifier' => 'boards'
    ],
    [
        'name' => 'Крепления',
        'css_modifier' => 'attachment'
    ],
    [
        'name' => 'Ботинкии',
        'css_modifier' => 'boots'
    ],
    [
        'name' => 'Одежда',
        'css_modifier' => 'clothing'
    ],
    [
        'name' => 'Инструменты',
        'css_modifier' => 'tools'
    ],
    [
        'name' => 'Разное',
        'css_modifier' => 'other'
    ],
];

$page_titles = [
    'main' => 'Главная'
];

$offers = [
    [
        'name' => '2014 Rossignol District Snowboard',
        'category' => $categories[0],
        'price' => 10999,
        'image_url' => 'img/lot-1.jpg',
        'expiration_date' => date("Y-m-d"),
    ],
    [
        'name' => 'DC Ply Mens 2016/2017 Snowboard',
        'category' => $categories[0],
        'price' => 159999,
        'image_url' => 'img/lot-2.jpg',
        'expiration_date' => date("Y-m-d", strtotime("+1 day")),
    ],
    [
        'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'category' => $categories[1],
        'price' => 8000,
        'image_url' => 'img/lot-3.jpg',
        'expiration_date' => date("Y-m-d", strtotime("+2 day")),
    ],
    [
        'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'category' => $categories[2],
        'price' => 10999,
        'image_url' => 'img/lot-4.jpg',
        'expiration_date' => date("Y-m-d", strtotime("+3 day")),
    ],
    [
        'name' => 'Куртка для сноуборда DC Mutiny Charocal',
        'category' => $categories[4],
        'price' => '7500',
        'image_url' => 'img/lot-5.jpg',
        'expiration_date' => date("Y-m-d", strtotime("+4 day")),
    ],
    [
        'name' => 'Маска Oakley Canopy',
        'category' => $categories[5],
        'price' => 5400,
        'image_url' => 'img/lot-6.jpg',
        'expiration_date' => date("Y-m-d", strtotime("+5 day")),
    ],
];

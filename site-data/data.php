<?php
$is_auth = rand(0, 1);

$user_name = 'Alexey'; // укажите здесь ваше имя

$categories = [
    'Доски и лыжи', 'Крепления', 'Ботинки', 'Одежда', 'Инструменты', 'Разное'
];

$offers = [
    [
        'name' => '2014 Rossignol District Snowboard',
        'category' => $categories[0],
        'price' => '10999',
        'image_url' => 'img/lot-1.jpg',
    ],
    [
        'name' => 'DC Ply Mens 2016/2017 Snowboard',
        'category' => $categories[0],
        'price' => '159999	',
        'image_url' => 'img/lot-2.jpg',
    ],
    [
        'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'category' => $categories[1],
        'price' => '8000',
        'image_url' => 'img/lot-3.jpg',
    ],
    [
        'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'category' => $categories[2],
        'price' => '10999',
        'image_url' => 'img/lot-4.jpg',
    ],
    [
        'name' => 'Куртка для сноуборда DC Mutiny Charocal',
        'category' => $categories[4],
        'price' => '7500',
        'image_url' => 'img/lot-5.jpg',
    ],
    [
        'name' => 'Маска Oakley Canopy',
        'category' => $categories[5],
        'price' => '5400',
        'image_url' => 'img/lot-6.jpg',
    ],
];

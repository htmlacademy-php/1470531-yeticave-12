<?php

if (file_exists('config.local.php')) {
    require_once 'config.local.php';
}

date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');

$is_auth = rand(0, 1);

$user_name = 'Alexey'; // укажите здесь ваше имя

$db = [
    'host' => 'localhost',
    'user' => 'user',
    'password' => '123456',
    'database' => 'yeticave'
];

$mysql = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
mysqli_set_charset($mysql, "utf8");

if (!$mysql) {
    print ('Ошибка подключения: ' . mysqli_connect_error());
    exit();
}

/* Корневая папка сайта*/
define ('SITE_ROOT', realpath(dirname(__FILE__)));

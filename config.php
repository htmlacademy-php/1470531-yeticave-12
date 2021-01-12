<?php
date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');

$is_auth = rand(0, 1);

$user_name = 'Alexey'; // укажите здесь ваше имя

$is_local = true;
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

if ($is_local) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

/* Корневая папка сайта*/
define ('SITE_ROOT', realpath(dirname(__FILE__)));

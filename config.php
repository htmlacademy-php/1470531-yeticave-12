<?php

require_once 'vendor/autoload.php';

if (file_exists('config.local.php')) {
    include_once 'config.local.php';
}

date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');

session_start();

$is_auth = isset($_SESSION['user']);
$user_name = $_SESSION['user']['name'] ?? '';

$db = [
    'host' => 'localhost',
    'user' => 'user',
    'password' => '123456',
    'database' => 'yeticave'
];

$mysql = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
mysqli_set_charset($mysql, "utf8");

if (!$mysql) {
    print('Ошибка подключения: ' . mysqli_connect_error());
    exit();
}

/* Корневая папка сайта*/
define('SITE_ROOT', realpath(dirname(__FILE__)));

/* Адрес сайта для email рассылки */
define('SITE_PATH', 'http://localhost:8090');

<?php
/**
 * Форматирует число. Отделяет пробелом тысячные части и добавляет символ рубля
 *
 * @param float $price Цена товара
 * @return string Цена товара с символом рубля
 */
function format_price ($price) {
    $rounded_price = ceil($price);

    if ($rounded_price < 1000) {
        return $rounded_price;
    }

    return number_format($rounded_price, 0, '', ' ') . ' ₽';
}

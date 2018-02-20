<?php
$title = 'Главная';
$error_title = 'This page is lost';
$container = 'main';

// Дефолтное описание лота со страницы lot.html
$lot_default_description = '
    Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив
    снег мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в
    двух направлениях, наделяет этот снаряд отличной гибкостью и отзывчивостью,
    а симметричная геометрия в сочетании с классическим прогибом кэмбер позволит
    уверенно держать высокие скорости. А если к концу катального дня сил совсем
    не останется, просто посмотрите на Вашу доску и улыбнитесь, крутая графика
    от Шона Кливера еще никого не оставляла равнодушным.';


$categories = ['boards' => 'Доски и лыжи', 'attachment' => 'Крепления', 'boots' => 'Ботинки',
    'clothing' => 'Одежда', 'tools' => 'Инструменты', 'other' => 'Разное'];

$lots = [
    ['name' => '2014 Rossignol District Snowboard', 'category_name' => 'Доски и лыжи',
        'price' => 10999, 'img_url' => 'img/lot-1.jpg', 'img_alt' => 'Сноуборд'],

    ['name' => 'DC Ply Mens 2016/2017 Snowboard', 'category_name' => 'Доски и лыжи',
        'price' => 159999, 'img_url' => 'img/lot-2.jpg', 'img_alt' => 'Сноуборд'],

    ['name' => 'Крепления Union Contact Pro 2015 года размер L/XL', 'category_name' => 'Крепления',
        'price' => 8000, 'img_url' => 'img/lot-3.jpg', 'img_alt' => 'Крепления'],

    ['name' => 'Ботинки для сноуборда DC Mutiny Charocal', 'category_name' => 'Ботинки',
        'price' => 10999, 'img_url' => 'img/lot-4.jpg', 'img_alt' => 'Ботинки'],

    ['name' => 'Куртка для сноуборда DC Mutiny Charocal', 'category_name' => 'Одежда',
        'price' => 7500, 'img_url' => 'img/lot-5.jpg', 'img_alt' => 'Куртка'],

    ['name' => 'Маска Oakley Canopy', 'category_name' => 'Разное',
        'price' => 5400, 'img_url' => 'img/lot-6.jpg', 'img_alt' => 'Маска']
];


// ставки пользователей, которыми надо заполнить таблицу
$bets = [
    ['name' => 'Иван', 'price' => 11500, 'ts' => strtotime('-' . rand(1, 50) .' minute')],
    ['name' => 'Константин', 'price' => 11000, 'ts' => strtotime('-' . rand(1, 18) .' hour')],
    ['name' => 'Евгений', 'price' => 10500, 'ts' => strtotime('-' . rand(25, 50) .' hour')],
    ['name' => 'Семён', 'price' => 10000, 'ts' => strtotime('last week')]
];

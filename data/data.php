<?php
$title = 'Главная';
$error_title = 'This page is lost';
$container = 'main';

// Дефолтное описание лота со страницы lot.html
$lot_description_default = '
    Легкий маневренный сноуборд, готовый дать жару в любом 
    парке, растопив снег мощным щелчкоми четкими дугами. 
    Стекловолокно Bi-Ax, уложенное в двух направлениях, 
    наделяет этот снаряд отличной гибкостью и отзывчивостью, 
    а симметричная геометрия в сочетании с классическим прогибом 
    кэмбер позволит уверенно держать высокие скорости. А если 
    к концу катального дня сил совсем не останется, просто 
    посмотрите на Вашу доску и улыбнитесь, крутая графика 
    от Шона Кливера еще никого не оставляла равнодушным.';

$categories = [

    'boards' => 'Доски и лыжи', 'attachment' =>
    'Крепления', 'boots' => 'Ботинки', 'clothing' => 'Одежда',
    'tools' => 'Инструменты', 'other' => 'Разное'

];

$lots = [
    [
        'lot_name' => '2014 Rossignol District Snowboard',
        'lot_category' => 'Доски и лыжи', 'lot_value' => 10999,
        'lot_img_url' => 'img/lot-1.jpg', 'lot_img_alt' => 'Сноуборд',
        'lot_description' => $lot_description_default
    ],
    [
        'lot_name' => 'DC Ply Mens 2016/2017 Snowboard',
        'lot_category' => 'Доски и лыжи', 'lot_value' => 159999,
        'lot_img_url' => 'img/lot-2.jpg', 'lot_img_alt' => 'Сноуборд',
        'lot_description' => $lot_description_default
    ],
    [
        'lot_name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
        'lot_category' => 'Крепления', 'lot_value' => 8000,
        'lot_img_url' => 'img/lot-3.jpg', 'lot_img_alt' => 'Крепления',
        'lot_description' => $lot_description_default
    ],
    [
        'lot_name' => 'Ботинки для сноуборда DC Mutiny Charocal',
        'lot_category' => 'Ботинки', 'lot_value' => 10999,
        'lot_img_url' => 'img/lot-4.jpg', 'lot_img_alt' => 'Ботинки',
        'lot_description' => $lot_description_default
    ],
    [   'lot_name' => 'Куртка для сноуборда DC Mutiny Charocal',
        'lot_category' => 'Одежда', 'lot_value' => 7500,
        'lot_img_url' => 'img/lot-5.jpg', 'lot_img_alt' => 'Куртка',
        'lot_description' => $lot_description_default
    ],
    [
        'lot_name' => 'Маска Oakley Canopy',
        'lot_category' => 'Разное', 'lot_value' => 5400,
        'lot_img_url' => 'img/lot-6.jpg', 'lot_img_alt' => 'Маска',
        'lot_description' => $lot_description_default
    ]
];


// ставки пользователей, которыми надо заполнить таблицу
$bets = [
    [
        'user_name' => 'Иван', 'bet_value' => 11500,
        'bet_ts' => strtotime('-' . rand(1, 50) .' minute')
    ],
    [
        'user_name' => 'Константин', 'bet_value' => 11000,
        'bet_ts' => strtotime('-' . rand(1, 18) .' hour')
    ],
    [
        'user_name' => 'Евгений', 'bet_value' => 10500,
        'bet_ts' => strtotime('-' . rand(25, 50) .' hour')
    ],
    [
        'user_name' => 'Семён', 'bet_value' => 10000,
        'bet_ts' => strtotime('last week')
    ]
];

$layout = ['is_auth' => $is_auth, 'index' => true,
    'title' => $title, 'user_name' => $user_name, 'user_avatar' => $user_avatar, 'categories' => $categories];

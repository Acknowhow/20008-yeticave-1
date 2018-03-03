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

$categories_eng = [
    'boards', 'attachment', 'boots', 'clothing', 'tools', 'other'
];

$categories_sql = 'SELECT * FROM categories ORDER BY category_id ASC';
$categories_fetched = select_data_column($link, $categories_sql, [], 'category_name');

$categories = array_combine($categories_eng, $categories_fetched);



//$users = [
//    [
//        'user_email' => 'ignat.v@gmail.com',
//        'user_name' => 'Игнат',
//        'user_password' => '$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka'
//    ],
//    [
//        'user_email' => 'kitty_93@li.ru',
//        'user_name' => 'Леночка',
//        'user_password' => '$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa'
//    ],
//    [
//        'user_email' => 'warrior07@mail.ru',
//        'user_name' => 'Руслан',
//        'user_password' => '$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW'
//    ]
//];

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

$layout = [
    'is_auth' => $is_auth, 'title' => $title,
    'user' => $user, 'categories' => $categories
];

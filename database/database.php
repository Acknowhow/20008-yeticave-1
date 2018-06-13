<?php
require_once 'DatabaseHelper.php';

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

$categories_eng =
    [
        'boards', 'attachment', 'boots',
        'clothing', 'tools', 'other'
    ];

//$categories_sql = '
//SELECT * FROM categories ORDER BY id ASC';
//
//
//$categories_fetched = select_data_column(
//    $link, $categories_sql, [], 'name');
//
//$categories = array_combine(
//    $categories_eng, $categories_fetched);

$categories = '';

$dbHelper = new DatabaseHelper(
    'localhost', 'root', 'vadi4ka365', 'yeti'
);

if ($dbHelper->getLastError()) {
    print $dbHelper->getLastError();
    exit();
}

else {
    $dbHelper->executeQuery('SELECT * FROM categories ORDER BY id ASC');

    if ($dbHelper->getLastError()) {
        print $dbHelper->getLastError();
    }
    else {
        $categories_fetched = $dbHelper->getAssocArray();
        $categories = array_combine(
            $categories_eng, $categories_fetched);
    }
}





$layout =
    [
        'is_auth' => $is_auth, 'user' => $user,
        'categories' => $categories
    ];

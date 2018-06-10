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
        $categories_fetched = $dbHelper->getArrayByColumnName('name');
        $categories = array_combine(
            $categories_eng, $categories_fetched);
    }
}

$dbHelper->executeQuery('SELECT COUNT(*) as count FROM lots');

if ($dbHelper->getLastError()) {
    print $dbHelper->getLastError();

} else {
    $lots_count = $dbHelper->getAssocArray();
}

$count = $lots_count[0]['count'];

$count = $count + 0;
$page_items = $page_items + 0;

$pages_count = ceil($count / $page_items);
$offset = ($curr_page - 1) * $page_items;

$pages = range(1, $pages_count);

$lots_offset_sql = '
SELECT 
  l.id,l.name,
  UNIX_TIMESTAMP(l.date_end),
  l.description,l.lot_path,
  l.value,l.step,
  l.user_id,l.category_id,c.name 
  AS lot_category 
FROM lots l
JOIN categories c ON l.category_id=c.id 
WHERE UNIX_TIMESTAMP(l.date_end) > UNIX_TIMESTAMP(NOW()) 
ORDER BY l.date_add DESC LIMIT ' .
    $page_items . ' OFFSET ' . $offset;

$dbHelper->executeQuery($lots_offset_sql);

if ($dbHelper->getLastError()) {
    print $dbHelper->getLastError();

} else {
    $lots_offset = $dbHelper->getAssocArray();
}

$count_bets = "
SELECT count(value) FROM bets WHERE lot_id=?";

$search_sql = '
SELECT
  id
FROM lots 
WHERE MATCH (name,description) AGAINST (?) 
AND UNIX_TIMESTAMP(`date_end`) > UNIX_TIMESTAMP(NOW())';

$search_sql_offset = '
SELECT 
  id
FROM lots 
WHERE MATCH (name,description) AGAINST (?) 
AND UNIX_TIMESTAMP(`date_end`) > UNIX_TIMESTAMP(NOW())
ORDER BY date_add DESC LIMIT ' .
    $page_items . ' OFFSET ' . $offset;

$search_result_sql = '
SELECT 
l.id,c.name AS category_name,l.name,l.value,l.date_end,l.lot_path 
FROM lots l 
JOIN categories c ON l.category_id=c.id
WHERE l.id=?';


$layout =
    [
        'is_auth' => $is_auth, 'user' => $user,
        'categories' => $categories
    ];

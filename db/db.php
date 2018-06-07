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

$categories_eng =
    [
        'boards', 'attachment', 'boots',
        'clothing', 'tools', 'other'
    ];

$categories_sql = '
SELECT * FROM categories ORDER BY id ASC';


$categories_fetched = select_data_column(
    $link, $categories_sql, [], 'name');

$categories = array_combine(
    $categories_eng, $categories_fetched);

$lots_count_sql = 'SELECT COUNT(*) as count FROM lots';
$lots_count = select_data_assoc($link, $lots_count_sql, []);

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

$lots_offset = select_data_assoc($link, $lots_offset_sql, []);

$lots_sql = '
SELECT 
  l.id,l.name,
  UNIX_TIMESTAMP(l.date_end),
  l.description,l.lot_path,
  l.value,l.step,
  l.user_id,l.category_id,c.name 
  AS lot_category 
FROM lots l
JOIN categories c ON l.category_id=c.id';

$lots = select_data_assoc($link, $lots_sql, []);


// Selecting all bets for the current lot by lot_id
$bets_sql = '
SELECT 
  b.id,b.lot_id,
  b.value, UNIX_TIMESTAMP(b.date_add),
  b.user_id,u.name AS bet_author 
FROM bets b 
JOIN users u ON b.user_id=u.id 
WHERE b.lot_id=? ORDER BY b.date_add 
DESC LIMIT ' . $bet_display_count;

// Query for my bets
$my_bets_sql = '
SELECT 
  b.value, UNIX_TIMESTAMP(b.date_add),b.user_id,
  IF(UNIX_TIMESTAMP(l.date_end) < UNIX_TIMESTAMP(NOW()),1,0) 
  AS bet_wins,l.id AS lot_id,l.name AS lot_name,
  UNIX_TIMESTAMP(l.date_end),l.lot_path,c.name 
  AS lot_category,u.contacts 
FROM bets b 
JOIN (lots l JOIN categories c ON l.category_id=c.id) 
ON l.id = b.lot_id JOIN users u ON u.id=l.user_id 
AND b.user_id=? ORDER BY b.date_add DESC';

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


$winner_sql = '
SELECT 
  l.id,l.name,
  l.date_add,l.date_end,
  l.description,l.lot_path,
  l.value,l.step,
  l.user_id,l.category_id,c.name 
AS lot_category,b.user_id AS lot_winner 
FROM lots l
JOIN categories c ON l.category_id=c.id 
JOIN bets b 
ON UNIX_TIMESTAMP(l.date_end) > UNIX_TIMESTAMP(NOW()) 
AND l.id=? ORDER BY b.date_add DESC LIMIT 1';

$layout =
    [
        'is_auth' => $is_auth, 'user' => $user,
        'categories' => $categories
    ];

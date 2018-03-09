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

$categories_sql = 'SELECT * FROM categories 
ORDER BY category_id ASC';

$categories_fetched = select_data_column($link, $categories_sql,
    [], 'category_name');

$categories = array_combine($categories_eng, $categories_fetched);

$lots_sql = 'SELECT l.lot_id,l.lot_name,
l.lot_date_add,l.lot_date_end,
l.lot_description,l.lot_img_url,
l.lot_value,l.lot_step,
l.user_id,l.category_id,c.category_name 
AS lot_category FROM lots l
JOIN categories c ON l.category_id=c.category_id 
ORDER BY l.lot_date_add DESC LIMIT ' . $page_items . ' OFFSET ' . $offset;


// Selecting all bets for the current lot by lot_id
$bets_sql = "SELECT b.bet_id,b.lot_id,
b.bet_value, UNIX_TIMESTAMP(b.bet_date_add),
b.user_id,u.user_name AS bet_author 
FROM bets b JOIN users u ON b.user_id=u.user_id 
WHERE b.lot_id=? ORDER BY b.bet_date_add 
DESC LIMIT $bet_display_count";

// Query for my bets
$my_bets_sql = 'SELECT b.bet_value, UNIX_TIMESTAMP(b.bet_date_add),
b.user_id,IF(UNIX_TIMESTAMP(l.lot_date_end) < UNIX_TIMESTAMP(NOW()),1,0) AS 
bet_wins,l.lot_name,UNIX_TIMESTAMP(l.lot_date_end),
l.lot_img_url,c.category_name AS lot_category,u.user_contacts FROM bets b 
JOIN (lots l JOIN categories c ON l.category_id=c.category_id) 
ON l.lot_id = b.lot_id INNER JOIN users u ON u.user_id=l.user_id 
AND b.user_id=? ORDER BY b.bet_date_add DESC';

$estimate_winner_sql = 'SELECT l.lot_id,l.lot_name,
l.lot_date_add,l.lot_date_end,
l.lot_description,l.lot_img_url,
l.lot_value,l.lot_step,
l.user_id,l.category_id,c.category_name 
AS lot_category,b.user_id AS lot_winner FROM lots l
INNER JOIN categories c ON l.category_id=c.category_id 
JOIN bets b ON UNIX_TIMESTAMP(l.lot_date_end) < UNIX_TIMESTAMP(NOW()) 
AND l.lot_id=? ORDER BY b.bet_date_add DESC LIMIT 1';

$estimate_winner = select_data_assoc($link, $estimate_winner_sql, [7]);

$layout =
    [
        'is_auth' => $is_auth, 'user' => $user,
        'categories' => $categories
    ];

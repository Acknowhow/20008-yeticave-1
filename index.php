<?php
session_start();
require_once 'vendor/autoload.php';

require 'defaults/config.php';
require 'defaults/var.php';
require 'resource/functions.php';

require 'database/database.php';
require 'markup/markup.php';

$index_title = '';
$category_title = '';

$user_id = isset($user['id']) ? $user['id'] : null;
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;

if ($category_id) {
    $category_title = 'Все лоты в категории';
    $lots_count_sql = '
    SELECT COUNT(*) as count 
    FROM lots 
    WHERE UNIX_TIMESTAMP(date_end) > UNIX_TIMESTAMP(NOW()) 
    AND category_id=' . $category_id;

} else {
    $index_title = 'Открытые лоты';
    $lots_count_sql = '
    SELECT COUNT(*) as count 
    FROM lots 
    WHERE UNIX_TIMESTAMP(date_end) > UNIX_TIMESTAMP(NOW())';
}

$dbHelper->executeQuery($lots_count_sql);

if ($dbHelper->getLastError()) {
    print $dbHelper->getLastError();

} else {
    $lots_count = $dbHelper->getAssocArray();
}

$count = $lots_count[0]['count'];
$page_items = $page_items + 0;

$pages_count = ceil($count / $page_items);
$offset = ($curr_page - 1) * $page_items;

$pages = range(1, $pages_count);

if ($category_id) {
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
    WHERE category_id=' . $category_id .
    ' AND UNIX_TIMESTAMP(date_end) > UNIX_TIMESTAMP(NOW())' .
    'ORDER BY l.date_add DESC LIMIT ' .
        $page_items . ' OFFSET ' . $offset;
} else {
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
    WHERE UNIX_TIMESTAMP(date_end) > UNIX_TIMESTAMP(NOW())  
    ORDER BY l.date_add DESC LIMIT ' .
        $page_items . ' OFFSET ' . $offset;
}

$dbHelper->executeQuery($lots_offset_sql);

if ($dbHelper->getLastError()) {
    print $dbHelper->getLastError();

} else {
    $lots_offset = $dbHelper->getAssocArray();
}

$pagination = includeTemplate('templates/pagination.php',
    [
        'page_items' => $page_items, 'pages' => $pages,
        'pages_count' => $pages_count, 'curr_page' => $curr_page
    ]
);

$content = includeTemplate('templates/index.php',
    [
        'categories' => $categories, 'index_title' => $index_title,
        'category_title' => $category_title,
        'lots' => $lots_offset, 'pagination' => $pagination,
    ]
);

$markup = new Markup('templates/layout.php',
    array_merge_recursive($layout,
        [
            'index' => $index, 'title' => $title,
            'nav' => $nav, 'content' => $content, 'search' => $search
        ]));
$markup->get_layout();

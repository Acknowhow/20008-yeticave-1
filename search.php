<?php
session_start();
require_once 'vendor/autoload.php';

require 'defaults/config.php';
require 'defaults/var.php';
require 'resource/functions.php';

require_once 'database/database.php';
require 'markup/markup.php';

$index = false;
$search_result_ids = '';

$search_result_array = [];
$search_result_item = '';

$bets_total = '';
$search = $_GET['search'] ?? '';

$nav = includeTemplate('templates/nav.php',
    [
        'categories' => $categories
    ]
);

if (empty($search)) {
    header('Location: index.php');
}

// Select all id's for lots which match search query

$search_sql = '
SELECT
  id
FROM lots WHERE MATCH (name,description) 
AGAINST (?) 
AND UNIX_TIMESTAMP(`date_end`) > UNIX_TIMESTAMP(NOW())';

$dbHelper->executeQuery($search_sql, [$search]);

if($dbHelper->getLastError()) {
    print $dbHelper->getLastError();

} else {
    $search_result_ids = $dbHelper->getAssocArray();
}

// Determine pagination count
$count = count($search_result_ids);
$count = $count + 0;
$page_items = $page_items + 0;

$pages_count = ceil($count / $page_items);

$offset = ($curr_page - 1) * $page_items;
$pages = range(1, $pages_count);

$search_sql_offset = '
SELECT 
  id
FROM lots 
WHERE MATCH (name,description) AGAINST (?) 
AND UNIX_TIMESTAMP(`date_end`) > UNIX_TIMESTAMP(NOW())
ORDER BY date_add DESC LIMIT ' .
    $page_items . ' OFFSET ' . $offset;


$dbHelper->executeQuery($search_sql_offset, [$search]);
if($dbHelper->getLastError()) {
    print $dbHelper->getLastError();

} else {
    $search_result_ids_offset = $dbHelper->getAssocArray();
}


foreach($search_result_ids_offset as $search_result_id) {

    $search_result_sql = '
    SELECT 
     l.id,c.name AS category_name,
     l.name,l.value,UNIX_TIMESTAMP(l.date_end),l.lot_path,count(b.value) 
    FROM bets b 
    JOIN (lots l JOIN categories c ON l.category_id=c.id)
    ON b.lot_id = l.id
    WHERE l.id=? GROUP BY l.id';

    $dbHelper->executeQuery($search_result_sql, [$search_result_id['id']]);
    if($dbHelper->getLastError()) {
        print $dbHelper->getLastError();

    } else {
        $search_result_item = $dbHelper->getAssocArray();
    }

    $search_result_item = $search_result_item[0];
    $search_result_array[] = $search_result_item;
}

$pagination_search = includeTemplate(
    'templates/pagination-search.php', [

    'page_items' => $page_items, 'pages' => $pages,
    'pages_count' => $pages_count, 'curr_page' => $curr_page, 'search' => $search
    ]
);

$content = includeTemplate('templates/search.php',
    [
        'result' => $search_result_array,
        'search' => $search, 'pagination_search' => $pagination_search
    ]);

$markup = new Markup('templates/layout.php',
    array_merge_recursive($layout,
        [
            'index' => $index, 'title' => $title,
            'nav' => $nav, 'content' => $content, 'search' => $search
        ]));

$markup->get_layout();

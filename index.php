<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'resource/functions.php';

require 'database/database.php';

require 'markup/markup.php';

$user_id = isset($user['id']) ? $user['id'] : null;
$lots_offset = '';

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

$pagination = includeTemplate('templates/pagination.php', [
    'page_items' => $page_items, 'pages' => $pages,
    'pages_count' => $pages_count, 'curr_page' => $curr_page
]);

$content = includeTemplate('templates/index.php',
    [
        'categories' => $categories,
        'lots' => $lots_offset, 'pagination' => $pagination,
        'link' => $link, 'winner_sql' => $winner_sql
    ]
);


$markup = new Markup('templates/layout.php',
    array_merge_recursive($layout,
        [
            'index' => $index, 'title' => $title,
            'nav' => $nav, 'content' => $content, 'search' => $search
        ]));
$markup->get_layout();

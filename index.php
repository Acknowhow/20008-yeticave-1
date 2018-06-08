<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'resource/functions.php';

require_once 'init.php';
require_once 'db/database.php';
require 'db/db.php';

require 'markup/markup.php';

//if (!isset($lots_offset)) {
//    mysqli_close($link);
//
//    print 'Can\'t resolve lots list';
//    exit();
//}

$winner = [];
$user_id = isset($user['id']) ? $user['id'] : null;

$dbHelper = new Database(
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
    }
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

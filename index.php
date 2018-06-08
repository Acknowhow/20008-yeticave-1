<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'resource/functions.php';

require 'database/database.php';

require 'markup/markup.php';



$user_id = isset($user['id']) ? $user['id'] : null;

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

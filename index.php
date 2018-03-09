<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'resource/functions.php';

require_once 'init.php';
require 'data/data.php';

require 'markup/markup.php';

if (empty($lots)) {
    mysqli_close($link);

    print 'Can\'t resolve lots list';
    exit();
}
$winner = [];
$user_id = isset($user['user_id']) ? $user['user_id'] : null;


$lots_fetched = $lots[0];

// winner lot
foreach($lots_fetched as $lot=>$value) {

 array_push($winner, $lot);
}




$pagination = include_template('templates/pagination.php', [
    'page_items' => $page_items, 'pages' => $pages,
    'pages_count' => $pages_count, 'curr_page' => $curr_page
]);


$content = include_template('templates/index.php',
    [
        'categories' => $categories,
        'lots' => $lots, 'pagination' => $pagination,
        'link' => $link, 'winner_sql' => $winner_sql
    ]
);

$markup = new Markup('templates/layout.php',
    array_merge_recursive($layout,
        [
            'index' => $index, 'title' => $title,
            'nav' => $nav, 'content' => $content
        ]));
$markup->get_layout();

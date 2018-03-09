<?php
session_start();

require 'defaults/config.php';
require 'defaults/var.php';
require 'resource/functions.php';

require_once 'init.php';
require 'data/data.php';

require 'markup/markup.php';

$result = '';
$defaults = [];

if (!empty($index)) {
    $pagination = include_template('templates/pagination.php', [
        'page_items' => $page_items, 'pages' => $pages,
        'pages_count' => $pages_count, 'curr_page' => $curr_page,
    ]);
}

$curr_page = isset($_GET['page']) ?
    $_GET['page'] : 1;
$page_items = 3;
$pages_count = null;

$lots_count_sql = 'SELECT COUNT(*) as count FROM lots';

$lots_count = select_data_assoc($link, $lots_count_sql, []);
$count = $lots_count[0]['count'];

$count = $count + 0;
$page_items = $page_items + 0;

$pages_count = ceil($count / $page_items);
$offset = ($curr_page - 1) * $page_items;

$pages = range(1, $pages_count);

$lots = select_data_assoc($link, $lots_sql, []);

if (empty($lots)) {
    mysqli_close($link);

    print 'Can\'t resolve lots list';
    exit();
}

$content = include_template('templates/index.php',
    [
        'categories' => $categories,
        'lots' => $lots
    ]
);

$markup = new Markup('templates/layout.php',
    array_merge_recursive($layout,
        [
            'index' => $index, 'title' => $title,
            'nav' => $nav, 'content' => $content
        ]));
$markup->get_layout();

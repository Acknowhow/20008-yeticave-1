<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'resource/functions.php';

require 'init.php';
require 'db/db.php';

require 'markup/markup.php';

$index = true;
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

// Only making this query to count Ids!
$search_result_ids = select_data_assoc(
    $link, $search_sql, [$search]);

// Determine pagination count
$count = count($search_result_ids);

$search_result_ids_offset = select_data_assoc(
    $link, $search_sql_offset, [$search]);

$count = $count + 0;
$page_items = $page_items + 0;

$pages_count = ceil($count / $page_items);

$offset = ($curr_page - 1) * $page_items;
$pages = range(1, $pages_count);


foreach($search_result_ids_offset as $search_result_id) {
    select_data_assoc(
        $link, $count_bets, [$search_result_id['id']]);

    $bets_total = select_data_assoc(
        $link, $count_bets, [$search_result_id['id']]);

    $search_result_item = select_data_assoc(
        $link, $search_result_sql, [$search_result_id['id']]);

    $search_result_item = $search_result_item[0];

    $search_result_item['count(value)'] = $bets_total[0]['count(value)'];
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

<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'resource/functions.php';

require 'init.php';
require 'data/data.php';

require 'markup/markup.php';

$index = true;
$search_result_ids = '';

$search_result_array = [];
$search_result_item = '';

$bets_total = '';

$nav = include_template('templates/nav.php',
    [
        'categories' => $categories
    ]
);

$pagination = include_template('templates/pagination.php', [
    'page_items' => $page_items, 'pages' => $pages,
    'pages_count' => $pages_count, 'curr_page' => $curr_page
]);

// sql query: search result
$search = $_GET['search'] ?? '';

if (empty($search)) {
    header('Location: index.php');
} else {

    $search_result_ids = select_data_assoc($link, $search_sql, [$search]);
    foreach($search_result_ids as $search_result_id) {
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
}

$content = include_template('templates/search.php',
    [
        'result' => $search_result_array,
        'search' => $search, 'pagination' => $pagination
    ]);

$markup = new Markup('templates/layout.php',
    array_merge_recursive($layout,
        [
            'index' => $index, 'title' => $title,
            'nav' => $nav, 'content' => $content
        ]));

$markup->get_layout();


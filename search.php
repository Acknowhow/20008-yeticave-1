<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'resource/functions.php';

require 'init.php';
require 'data/data.php';

require 'markup/markup.php';

$index = false;
$search_result_ids = '';

$search_result_array = [];
$search_result_item = '';

$bets_total = '';

$nav = include_template('templates/nav.php',
    [
        'categories' => $categories
    ]
);

// sql query: search result
$search = $_GET['search'] ?? '';

if ($search) {
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


    var_dump($search_result_array);
}



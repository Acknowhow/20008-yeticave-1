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

$nav = include_template('templates/nav.php',
    [
        'categories' => $categories
    ]
);

// sql query: search result
$search = $_GET['search'] ?? '';

if ($search) {
    $search_result = select_data_assoc($link, $search_result_sql, [3]);

    $bets_result = select_data_assoc($link, $count_bets, [3]);

    var_dump($bets_result);

    var_dump($search_result);

}



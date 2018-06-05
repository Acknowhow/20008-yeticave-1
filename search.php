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
    $search_result_ids = select_data_assoc($link, $search_sql, [$search]) ?? '';

    var_dump(select_data_assoc($link, $search_result_sql, ['3']));


    if (!empty($search_result_ids)) {

        foreach($search_result_ids as $search_result) {

//            $search_result_item = select_data_assoc($link, $search_result_sql, [$search_result['id']]);


        }

    }



//    $content = include_template('templates/search.php',
//        [
//            'search_result' => $search_result
//        ]
//    );
}



<?php
require_once 'data/data.php';
require_once 'functions.php';
require_once 'defaults/config.php';
require 'defaults/var.php';
//
//$error = false;
$content = '';
$lot_id = isset($_GET['lot-id']) ? $_GET['lot-id'] : null;
//
$lot = [];


// in the end send different flags according to content variable
// – if lot-content is true, print lot-content
// – if bet-content is true, print bet-content etc....

if (isset($lot_id)) {
    var_dump($lot_id);

    if(array_key_exists($lot_id, $lots) === true) {
        $lot = $lots[$lot_id];
        $content = include_template('templates/lot.php',
            [
                'categories' => $categories, 'bets' => $bets,
                'lot_name' => $lot['lot_name'], 'lot_category' => $lot['lot_category'],

                'lot_value' => $lot['lot_value'], 'lot_img_url' => $lot['lot_img_url'],
                'lot_img_alt' => $lot['lot_img_alt'], 'lot_description' => $lot['lot_description']
            ]);
        print include_template('templates/layout.php',
            [
                'is_auth' => $is_auth, 'index' => $index,
                'title' => $title, 'user_name' => $user_name,
                'user_avatar' => $user_avatar, 'content' => $content, 'categories' => $categories
            ]
        );
    }
    else {
        $error = true;
    }
}




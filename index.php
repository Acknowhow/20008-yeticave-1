<?php
require 'defaults/config.php';
require 'defaults/var.php';

require 'data/data.php';
require 'functions.php';

error_reporting(-1);
ini_set("display_errors", 1);

if (isset($_GET['id'])) {
    $index = false;
    $title = $error_title;

    if (!isset($lots[$lot_id])) {
        http_response_code(404);
        $content = include_template('templates/404.php',
            [
                'container' => $container
            ]);
    } else {
        $lot = $lots[$lot_id];
        $content = include_template('templates/lot.php',

            [
                'categories' => $categories, 'bets' => $bets,
                'lot_name' => $lot['lot_name'], 'lot_category' => $lot['lot_category'],

                'lot_value' => $lot['lot_value'], 'lot_img_url' => $lot['lot_img_url'],
                'lot_img_alt' => $lot['lot_img_alt'], 'lot_description' => $lot['lot_description']
            ]);

    }
}

$content = include_template('templates/index.php',
    [
        'categories' => $categories,
        'lots' => $lots, 'time_left' => $time_left
    ]);

print include_template('templates/layout.php',
    [
        'is_auth' => $is_auth, 'index' => $index,
        'title' => $title, 'user_name' => $user_name,
        'user_avatar' => $user_avatar, 'content' => $content, 'categories' => $categories
    ]);

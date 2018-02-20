<?php
require 'functions.php';
require 'data.php';

require 'defaults/var.php';
require 'defaults/config.php';

error_reporting(-1);
ini_set("display_errors", 1);

$index = true;
$id = isset($_GET['id']) ? $_GET['id'] : null;
$lot = &$id;
$content = [];

if(!empty($id)){
    $index = false;
    $lot['name'] = $error_title;

    http_response_code(404);
    $content = include_template('templates/404.php', [

            'container' => $container
        ]);
    } else {
        $content = include_template('templates/lot.php', [

            'categories' => $categories, 'lot' => $lot,
            'lot_default_description' => $lot_default_description,
            'bets' => $bets
        ]);
    }
}

$content = include_template('templates/index.php', [
    'categories' => $categories, 'lots' => $lots,
    'difference_hours' => $lot_time_remaining
]);

print include_template('templates/layout.php', [
    'content' => $content, 'title' => $title, 'is_auth' => $is_auth,
    'user_avatar' => $user_avatar, 'user_name' => $user_name, 'categories' => $categories
]);




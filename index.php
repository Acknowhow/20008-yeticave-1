<?php

require 'functions.php';
require 'config.php';
require 'data.php';

error_reporting(-1);
ini_set("display_errors", 1);

if(isset($_GET['id'])){
    $index = null;
    $id = $_GET['id'];

    $lot = $lots[$id];
    if(!$lot['name']) {
        $title = $error_title;

        http_response_code(404);
        $content = include_template('templates/404.php', [

            'container' => $container
        ]);
    } else {

        $title = $lot['name'];
        $content = include_template('templates/lot.php', [

            'categories' => $categories, 'lot' => $lot, 'lot_text' => $lot_text, 'bets' => $bets
        ]);
    }
}

$content = include_template('templates/index.php', [
    'categories' => $categories, 'lots' => $lots, 'difference_hours' => $difference_hours
]);

print include_template('templates/layout.php', [
    'content' => $content, 'title' => $title, 'is_auth' => $is_auth,

    'user_avatar' => $user_avatar, 'user_name' => $user_name, 'categories' => $categories
]);




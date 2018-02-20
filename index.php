<?php
require 'functions.php';
require 'data/data.php';

require 'defaults/var.php';
require 'defaults/config.php';

error_reporting(-1);
ini_set("display_errors", 1);

if(isset($_GET['id']) && empty($lots[$id])) {
    $index = false;
    $title = $error_title;

    http_response_code(404);
    $content = include_template('templates/404.php', [

        'container' => $container
    ]);
} elseif (isset($_GET['id']) && !empty($lots[$id])) {
    $lot = $lots[$id];

    $content = include_template('templates/lot.php', [
        'categories' => $categories, 'bets' => $bets, 'id' => $id,
        'name' => $lot['name'], 'category' => $lot['category'],

        'price' => $lot['price'], 'img_url' => $lot['img_url'],
        'img_alt' => $lot['img_alt'], 'description' => $lot['description']
    ]);
}

$content = include_template('templates/index.php', [
    'categories' => $categories,
    'lots' => $lots, 'time_remaining' => $time_remaining
]);

print include_template('templates/layout.php', [
    'content' => $content, 'title' => $title, 'is_auth' => $is_auth,
    'user_avatar' => $user_avatar, 'user_name' => $user_name, 'categories' => $categories
]);




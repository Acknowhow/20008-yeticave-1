<?php
require 'data/data.php';
require 'functions.php';
require 'defaults/config.php';
require 'defaults/var.php';

require ('lot.php');

$index_content = '';


$index_content = include_template('templates/index.php',
        [
            'categories' => $categories,
            'lots' => $lots, 'time_left' => $time_left
        ]
);

var_dump($content);

if (!empty($content)) {
    $content = ob_get_contents();
    $index_content = $content;
}
print include_template('templates/layout.php',
    [
        'is_auth' => $is_auth, 'index' => $index,
        'title' => $title, 'user_name' => $user_name,
        'user_avatar' => $user_avatar, 'content' => $index_content, 'categories' => $categories
    ]
);


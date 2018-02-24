<?php
require 'data/data.php';
require 'functions.php';
require 'defaults/config.php';

$index = true;
$content = include_template('templates/index.php',
        [
            'categories' => $categories,
            'lots' => $lots, 'time_left' => $time_left
        ]
);

print include_template('templates/layout.php',
    [
        'is_auth' => $is_auth, 'index' => $index,
        'title' => $title, 'user_name' => $user_name,
        'user_avatar' => $user_avatar, 'content' => $content, 'categories' => $categories
    ]
);


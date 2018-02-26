<?php
require 'defaults/config.php';
require 'data/data.php';
require 'functions.php';

$index = true;
$nav = '';

$content = include_template('templates/index.php',
    [
        'categories' => $categories,
        'lots' => $lots, 'time_left' => $time_left
    ]
);
if (isset($_SESSION['error'])) {
    print 'this is error';
}

if (isset($_GET['lot']) || isset($_GET['add-lot'])) {
    $nav = include_template('templates/nav.php', [

        'categories' => $categories
    ]);
}

if (isset($_GET['lot']) && isset($_SESSION['lot'])) {
    $index = false;

    $content = $_SESSION['lot'];
    unset($_SESSION['lot']);
}


$template = ['content' => $content];

print include_template('templates/layout.php', array_merge_recursive($layout, $template)

);



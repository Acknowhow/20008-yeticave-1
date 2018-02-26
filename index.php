<?php
require 'defaults/config.php';
require 'data/data.php';
require 'functions.php';
require 'defaults/var.php';

$content = include_template('templates/index.php',
    [
        'categories' => $categories,
        'lots' => $lots, 'time_left' => $time_left
    ]
);

print include_template('templates/layout.php',
                       array_merge_recursive($layout, [
                           'content' => $content, 'index' => $index, 'nav' => $nav]));

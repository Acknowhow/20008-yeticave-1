<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'data/data.php';
require 'functions.php';

require 'markup/markup.php';
$content = include_template('templates/index.php',
    [
        'categories' => $categories,
        'lots' => $lots, 'time_left' => $time_left
    ]
);

$markup = new Markup('templates/layout.php',
                       array_merge_recursive($layout, [
                           'content' => $content, 'index' => $index, 'nav' => $nav
                       ]));
$markup->get_layout();

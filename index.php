<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'functions.php';

require_once 'init.php';
require 'data/data.php';

require 'markup/markup.php';
var_dump($user);
$content = include_template('templates/index.php',
    [
        'categories' => $categories,
        'lots' => $lots, 'time_left' => $time_left
    ]
);

$markup = new Markup('templates/layout.php',
    array_merge_recursive($layout,
        [
            'index' => $index,
            'nav' => $nav, 'content' => $content
        ]));
$markup->get_layout();

<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'util/functions.php';

require_once 'init.php';
require 'data/data.php';

require 'markup/markup.php';

$content = include_template('templates/index.php',
    [
        'categories' => $categories,
        'lots' => $lots
    ]
);

$markup = new Markup('templates/layout.php',
    array_merge_recursive($layout,
        [
            'index' => $index, 'title' => $title,
            'nav' => $nav, 'content' => $content
        ]));
$markup->get_layout();

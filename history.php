<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'data/data.php';
require 'functions.php';

require 'markup/markup.php';
$cookie_value = isset($_COOKIE['lot_visited']) ?
    $_COOKIE['lot_visited'] : '';

$lots_visited = [];

if (empty($cookie_value)) {
    $content = 'Здесь отображается история просмотра лотов';
} elseif (!empty($cookie_value)) {
    $index = false;
    $lot_ids = json_decode($cookie_value);

    foreach ($lot_ids as $id) {
        $lots_visited[] = $lots[$id];
    }

    $nav = include_template('templates/nav.php', [
        'categories' => $categories
    ]);

    $content = include_template('templates/all-lots.php', [
        'lots_visited' => $lots_visited
    ]);

}
$markup = new Markup('templates/layout.php',
    array_merge_recursive($layout, [
        'content' => $content, 'index' => $index,
        'nav' => $nav
    ]));
$markup->get_layout();

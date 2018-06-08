<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'resource/functions.php';

require_once 'init.php';
require 'database/database.php';

require 'markup/markup.php';

$index = false;
$title = 'История просмотров';
$cookie_lot_visited_value = isset($_COOKIE['lot_visited']) ?
    $_COOKIE['lot_visited'] : '';
$nav = includeTemplate('templates/nav.php',
    [
        'categories' => $categories
    ]);

/* Если существует cookie_lot_value, но нет лотов в БД */
if (empty($cookie_lot_visited_value) || empty($lots_offset)) {
    $content = 'Здесь отображается история просмотра лотов';

} elseif (!empty($cookie_lot_visited_value) && !empty($lots_offset)) {
    $index = false;
    $lot_ids = json_decode($cookie_lot_visited_value);

    $lots_offset = array_intersect_key($lots_offset, $lot_ids);
    $content = includeTemplate('templates/history.php',
        [
            'lots' => $lots_offset
        ]);
}
$markup = new Markup('templates/layout.php', array_merge_recursive(
    $layout,
    [
        'index' => $index, 'title' => $title,
        'nav' => $nav, 'content' => $content, 'search' => $search
    ]));
$markup->get_layout();

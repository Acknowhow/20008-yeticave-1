<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'util/functions.php';

require_once 'init.php';
require 'data/data.php';

require 'markup/markup.php';
$cookie_lot_visited_value = isset($_COOKIE['lot_visited']) ?
    $_COOKIE['lot_visited'] : '';

/* Если существует cookie_lot_value, но нет лотов в БД */
if (empty($cookie_lot_visited_value) || empty($lots)) {
    $content = 'Здесь отображается история просмотра лотов';

} elseif (!empty($cookie_lot_visited_value) && !empty($lots)) {
    $index = false;
    $lot_ids = json_decode($cookie_lot_visited_value);

    $lots = array_intersect_key($lots, $lot_ids);
    $content = include_template('templates/history.php',
        [
            'lots' => $lots
        ]);
}
$markup = new Markup('templates/layout.php', array_merge_recursive(
    $layout,
    [
        'index' => $index,
        'nav' => $nav, 'content' => $content
    ]));
$markup->get_layout();

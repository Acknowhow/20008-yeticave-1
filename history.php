<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'util/functions.php';

require 'init.php';
require 'data/data.php';

require 'markup/markup.php';

// Need to add check to see whether each lot in
// cookie is present in db
$cookie_lot_value = isset($_COOKIE['lot_visited']) ?
    $_COOKIE['lot_visited'] : '';

$lots_visited = [];

if (empty($cookie_lot_value)) {
    $content = 'Здесь отображается история просмотра лотов';
} elseif (!empty($cookie_lot_value)) {
    $index = false;
    $lot_ids = json_decode($cookie_lot_value);

    $lots = array_intersect_key($lots, $lot_ids);
//
//    foreach ($lot_ids as $id) {
//        $lots_visited[] = $lots[$id];
//    }
    echo 'Current db lots list is :';
    echo '<br>';
    var_dump(count(array_keys($lots)));
    echo '<br>';
    echo 'Current lot_ids list is :';
    echo '<br>';
    var_dump(count(array_keys($lot_ids)));
    // In case if db was dumped, return only those lots
    // That exists
    var_dump($lots = array_intersect_key($lots, $lot_ids));

//    if(!empty($lots_visited)) {
//        $lots_visited = filterArray($lots_visited, '');
//        var_dump($lots_visited);
//    }

    //    $content = include_template('templates/all-lots.php', [
    //        'lots_visited_ids' => $lots_visited_ids
    //    ]);

}
$markup = new Markup('templates/layout.php',
    array_merge_recursive($layout,
        [
            'index' => $index,
            'nav' => $nav, 'content' => $content
        ]));
$markup->get_layout();

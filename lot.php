<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'data/data.php';
require 'functions.php';

require 'markup/markup.php';
$lot_id = isset($_GET['lot_id']) ? $_GET['lot_id'] : null;

if (isset($lot_id)) {
    $index = false;

    if (isset($_SESSION['lot_added'])) {
        $lot = $_SESSION['lot_added'];
        array_push($lots, $lot);

        $lot_id = $_GET['lot_id'];
        unset($_SESSION['lot_added']);
    } else {
        $lot = $lots[$lot_id];
    }

    if (array_key_exists($lot_id, $lots) === true) {
        $nav = include_template('templates/nav.php', [
           'categories' => $categories
        ]);

        $content = include_template('templates/lot.php',
            [
                'categories' => $categories, 'bets' => $bets,
                'lot_name' => $lot['lot_name'], 'lot_category' => $lot['lot_category'],

                'lot_value' => $lot['lot_value'], 'lot_img_url' => $lot['lot_img_url'],
                'lot_img_alt' => $lot['lot_img_alt'], 'lot_description' => $lot['lot_description']
            ]);
    } elseif (array_key_exists($lot_id, $lot) === false) {
        $layout['title'] = $error_title;
        $content = include_template('templates/404.php',
                                    [
                                        'container' => $container
                                    ]);
    }
}

$markup = new Markup('templates/layout.php',
                     array_merge_recursive($layout, [
                         'content' => $content, 'index' => $index,
                         'nav' => $nav
                     ]));
$markup->get_layout();

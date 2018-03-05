<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'util/functions.php';

require_once 'init.php';
require 'data/data.php';

require 'markup/markup.php';
$my_lot = false;
$lot_id = isset($_GET['lot_id']) ? $_GET['lot_id'] : null;

$cookie_lot_name = 'lot_visited';
$cookie_lot_value = isset($_COOKIE['lot_visited']) ?
    $_COOKIE['lot_visited'] : [];

$expire = time() + 60 * 60 * 24 * 30;
$path = '/';

$category_id_sql = 'SELECT category_id FROM categories WHERE category_name=?';
$user_id = $_SESSION['user']['user_id'];


if (isset($lot_id)) {
    $index = false;

    $my_lots_sql = 'SELECT * FROM lots WHERE user_id=?';
    $my_lots_fetched = select_data_assoc($link, $my_lots_sql, [$user_id]);

    if (array_key_exists($lot_id, $my_lots_fetched) === true) {
        $my_lot = true;
    }

    if (isset($_GET['lot_added']) && isset($_SESSION['lot_added'])) {
        $my_lot = true;

        $lot = $_SESSION['lot_added'];
        $lot_id = $lot['lot_id'];

        unset($_SESSION['lot_added']);
    }


    elseif (!isset($_GET['lot_added']) && (array_key_exists($lot_id, $lots) === true)) {
        $lot = $lots[$lot_id];
    }

    elseif (!isset($_GET['lot_added']) && !array_key_exists($lot_id, $lot)) {
        $layout['title'] = $error_title;

        $content = include_template('templates/404.php',
            [
                'container' => $container
            ]);
    }

    if (!empty($cookie_lot_value)) {
        $cookie_lot_value = json_decode($cookie_lot_value, true);

        if (!in_array($lot_id, $cookie_lot_value)) {
            $cookie_lot_value[] = $lot_id;
        }
    } elseif (empty($cookie_lot_value)) {
        $cookie_lot_value[] = $lot_id;
    }

    $cookie_lot_value = json_encode($cookie_lot_value);
    setcookie($cookie_lot_name, $cookie_lot_value, $expire, $path);

    $nav = include_template('templates/nav.php',
        [

            'categories' => $categories
        ]);


    $content = include_template('templates/lot.php',
        [
            'is_auth' => $is_auth,
            'categories' => $categories, 'bets' => $bets,
            'my_lot' => $my_lot,
            'lot_name' => $lot['lot_name'], 'lot_category' => $lot['lot_category'],

            'lot_value' => $lot['lot_value'], 'lot_img_url' => $lot['lot_img_url'],
            'lot_img_alt' => $lot['lot_name'], 'lot_description' => $lot['lot_description']
        ]);
}

$markup = new Markup('templates/layout.php',
    array_merge_recursive($layout,
        [
            'index' => $index,
            'nav' => $nav, 'content' => $content
        ]));
$markup->get_layout();

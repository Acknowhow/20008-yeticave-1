<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'functions.php';

require_once 'init.php';
require 'data/data.php';

require 'markup/markup.php';
$lot_id = isset($_GET['lot_id']) ? $_GET['lot_id'] : null;

$cookie_name = 'lot_visited';
$cookie_value = isset($_COOKIE['lot_visited']) ?
    $_COOKIE['lot_visited'] : [];

$expire = time() + 60 * 60 * 24 * 30;
$path = '/';

$category_id_sql = 'SELECT category_id FROM categories WHERE category_name=?';

if (isset($lot_id)) {
    $index = false;

    if (isset($_GET['lot_added']) && isset($_SESSION['lot_added'])) {

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

    if (!empty($cookie_value)) {
        $cookie_value = json_decode($cookie_value, true);

        if (!in_array($lot_id, $cookie_value)) {
            $cookie_value[] = $lot_id;
        }
    } elseif (empty($cookie_value)) {
        $cookie_value[] = $lot_id;
    }

    $cookie_value = json_encode($cookie_value);
    setcookie($cookie_name, $cookie_value, $expire, $path);

    $nav = include_template('templates/nav.php',
        [

            'categories' => $categories
        ]);

    $content = include_template('templates/lot.php',
        [
            'is_auth' => $is_auth,
            'categories' => $categories, 'bets' => $bets,
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

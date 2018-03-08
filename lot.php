<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'util/functions.php';

require 'init.php';
require 'data/data.php';

require 'markup/markup.php';
$my_lot = false;
$bet_author = false;

$lot_id = isset($_GET['lot_id']) ? $_GET['lot_id'] : '';

$cookie_lot_visited_name = 'lot_visited';
$cookie_lot_visited_value =
    isset($_COOKIE['lot_visited']) ? $_COOKIE['lot_visited'] : [];
$expire = time() + 60 * 60 * 24 * 30;
$path = '/';
$category_id_sql = 'SELECT category_id 
FROM categories WHERE category_name=?';
$bets = [];

$user_id = isset($_SESSION['user']['user_id']) ?
    $_SESSION['user']['user_id'] : null;

$bet_error = isset($_SESSION['user'][$user_id]['bet_error']) ?
    $_SESSION['user'][$user_id]['bet_error'] : null;

if (!empty($user_id)) {
    $my_lots_sql = 'SELECT * FROM lots WHERE user_id=?';
    $my_lots_fetched = select_data_assoc($link,
        $my_lots_sql, [$user_id]);

    $my_lot_fetched = filterArrayById($my_lots_fetched,
        'lot_id', $lot_id);

    if (!empty($my_lot_fetched)) {
        $my_lot = true;
    }

    if (empty($my_lot_fetched)) {
        $bets = select_data_assoc($link, $bets_sql, [$lot_id]);
    }
}

if (!empty($bets) && $bets[0]['user_id'] === $user_id) {
    $bet_author = true;
}

if (isset($lot_id)) {
    $index = false;
    $lot = array_values(filterArrayById($lots, 'lot_id', intval($lot_id)));

    if (empty($lot[0])) {
        print 'Can\'t fetch lot by id';
        exit();
    }

    $lot = $lot[0];
    $cookie_lot_visited_value = json_decode($cookie_lot_visited_value,
        true);

    if (!array_key_exists($lot_id, $cookie_lot_visited_value)) {
        $cookie_lot_visited_value[] = $lot_id;
    } elseif (empty($cookie_lot_visited_value)) {
        $cookie_lot_visited_value[] = $lot_id;
    }

    $cookie_lot_visited_value = json_encode($cookie_lot_visited_value);
    setcookie($cookie_lot_visited_name, $cookie_lot_visited_value,
        $expire, $path);

    $title = $lot['lot_name'];
    $nav = include_template('templates/nav.php',
        [
            'categories' => $categories
        ]
    );
    $content = include_template('templates/lot.php',
        [
            'is_auth' => $is_auth,
            'categories' => $categories, 'bets' => $bets,
            'bet_author' => $bet_author, 'my_lot' => $my_lot,
            'bet_error' => $bet_error, 'lot_id' => $lot_id,
            'user_id' => $user_id, 'lot_name' => $lot['lot_name'],
            'lot_category' => $lot['lot_category'],
            'lot_value' => $lot['lot_value'], 'lot_step' => $lot['lot_step'],
            'lot_img_url' => $lot['lot_img_url'],
            'lot_img_alt' => $lot['lot_name'],
            'lot_description' => $lot['lot_description']
        ]
    );
}
$markup = new Markup('templates/layout.php',
    array_merge_recursive($layout,
        [
            'index' => $index, 'title' => $title,
            'nav' => $nav, 'content' => $content
        ]));
$markup->get_layout();

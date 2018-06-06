<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'resource/functions.php';

require 'init.php';
require 'data/data.php';

require 'markup/markup.php';

$index = false;
$my_lot = false;
$bet_author = false;

$lot_id = isset($_GET['lot_id']) ? $_GET['lot_id'] : null;
$user_id = isset($_SESSION['user']) ? $_SESSION['user']['id'] : null;

$cookie_lot_visited_name = 'lot_visited';
$cookie_lot_visited_value =
    isset($_COOKIE['lot_visited']) ? $_COOKIE['lot_visited'] : [];
$expire = time() + 60 * 60 * 24 * 30;
$path = '/';

$bets = select_data_assoc($link, $bets_sql, [$lot_id]) ?? [];

$bet_error = isset($_SESSION['user'][$user_id]['bet_error']) ?
    $_SESSION['user'][$user_id]['bet_error'] : null;

$nav = include_template('templates/nav.php',
    [
        'categories' => $categories
    ]
);

if (empty($lot_id)) {
    $title = 'Страница не существует';
    $content = include_template('templates/404.php', []
    );

    die();
} else {

    $lot = array_values(filterArrayById(
        $lots, 'id', intval($lot_id)));

    $lot = $lot[0];
}

if (!empty($user_id)) {
    $my_lot = $lot['user_id'] === $user_id ? true : false;
}

// Get last bet made
if (!empty($bets) && $bets[0]['user_id'] === $user_id) {
    $bet_author = true;
}

if (!empty($bet_error)) {
    $_SESSION['user'][$user_id]['bet_error'] = [];

    unset($_SESSION['user'][$user_id]['bet_error']);
}

if (empty($lot)) {
    print 'Can\'t fetch lot by id';
    exit();
}

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

$title = $lot['name'];
$content = include_template('templates/lot.php',
    [
        'is_auth' => $is_auth,
        'categories' => $categories, 'bets' => $bets,
        'bet_author' => $bet_author, 'my_lot' => $my_lot,
        'bet_error' => $bet_error, 'lot_id' => $lot_id,

        'user_id' => $user_id, 'lot_name' => $lot['name'],
        'lot_category' => $lot['lot_category'],
        'lot_value' => $lot['value'], 'lot_step' => $lot['step'],
        'lot_img_url' => $lot['lot_path'],

        'lot_img_alt' => $lot['name'],
        'lot_description' => $lot['description']
    ]
);

$markup = new Markup('templates/layout.php',
    array_merge_recursive($layout,
        [
            'index' => $index, 'title' => $title,
            'nav' => $nav, 'content' => $content, 'search' => $search
        ]));

$markup->get_layout();



<?php
session_start();
require 'data/data.php';
require 'functions.php';
require 'defaults/config.php';

$error = false;
$content = '';
$lot_id = isset($_GET['lot-id']) ? $_GET['lot-id'] : null;
$lot = [];
$index = false;

if (isset($lot_id)) {
    if(array_key_exists($lot_id, $lots) === true) {
        $lot = $lots[$lot_id];
        $content = include_template('templates/lot.php',
            [
                'categories' => $categories, 'bets' => $bets,
                'lot_name' => $lot['lot_name'], 'lot_category' => $lot['lot_category'],

                'lot_value' => $lot['lot_value'], 'lot_img_url' => $lot['lot_img_url'],
                'lot_img_alt' => $lot['lot_img_alt'], 'lot_description' => $lot['lot_description']
            ]);

        $_SESSION['lot'] = $content;
        header('Location: index.php?lot=true');
    }
    else {
        $error = true;
    }
}




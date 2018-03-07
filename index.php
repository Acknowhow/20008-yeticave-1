<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'util/functions.php';

require_once 'init.php';
require 'data/data.php';

require 'markup/markup.php';


$bet = $bets[0];
//$expires_date = $bet['DATE_FORMAT(b.bet_date_add, \'%Y.%m.%d %H:%i:%s\')'];

//$expires_date = new DateTime($expires_string, $dtz);
//$current_date = new DateTime('now', $dtz);
//
//$difference_date = $expires_date->diff($current_date);

//$expiresString = $expires_string->format('Y.m.d H:i:s');
//$currentString = $current_date->format('Y.m.d H:i:s');
//$diffString = $difference->format('%h');

var_dump($bet);


$content = include_template('templates/index.php',
    [
        'categories' => $categories,
        'lots' => $lots
    ]
);

$markup = new Markup('templates/layout.php',
    array_merge_recursive($layout,
        [
            'index' => $index,
            'nav' => $nav, 'content' => $content
        ]));
$markup->get_layout();

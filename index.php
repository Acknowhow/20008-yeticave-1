<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'util/functions.php';

require_once 'init.php';
require 'data/data.php';

require 'markup/markup.php';

var_dump('Bets are:');
var_dump('<br>');
var_dump($bets);


//// display dateTime from db
//$dtz = new DateTimeZone(date_default_timezone_get());
//// get date from DB
//$dt = new DateTime('now', $dtz);
//// then format it
//echo $dt->format('Y.m.d H:i:s');


$content = include_template('templates/index.php',
    [
        'categories' => $categories,
        'lots' => $lots, 'time_left' => $time_left
    ]
);

$markup = new Markup('templates/layout.php',
    array_merge_recursive($layout,
        [
            'index' => $index,
            'nav' => $nav, 'content' => $content
        ]));
$markup->get_layout();

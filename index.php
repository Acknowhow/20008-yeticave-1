<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'data/data.php';
require 'functions.php';

require 'markup/markup.php';
$content = include_template('templates/index.php',
    [
        'categories' => $categories,
        'lots' => $lots, 'time_left' => $time_left
    ]
);

if (isset($_GET['success']) && $_GET['success'] === 'false') {
    $error = true;
    $errors = $_SESSION['error_state'];
}

if (!empty($check_key)) {

    // Can use foreach function here
    foreach ($form_data as $key => $value) {
        $form_defaults[$check_key][$key]['input'] = $value ? $value : '';
    }
}

$markup = new Markup('templates/layout.php',
                       array_merge_recursive($layout, [
                           'content' => $content, 'index' => $index, 'nav' => $nav
                       ]));
$markup->get_layout();

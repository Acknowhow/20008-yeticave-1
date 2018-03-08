<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'util/functions.php';

require 'defaults/add-lot.php';
require 'errors/add-lot.php';

require_once 'init.php';
require 'data/data.php';

require 'markup/markup.php';
$index = false;
$title = 'Добавление лота';
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['user_id'])) {
    http_response_code(403);
    exit('Вы не авторизованы ' . http_response_code() . '');
}

$user_id = $_SESSION['user']['user_id'];
$lot_data = [];
$lot_errors = [];

$required = [
    'lot_name', 'lot_category',
    'lot_description', 'lot_value', 'lot_step', 'lot_date_end'
];
$rules = [
    'lot_value' => 'validateLotValue',
    'lot_step' => 'validateLotStep', 'lot_date_end' => 'validateDate'
];

$category_id_sql = 'SELECT category_id FROM 
categories WHERE category_name=?';

$uploaded = '';
$lot_upload_error = '';
$validation_result = '';

$nav = include_template('templates/nav.php', [
    'categories' => $categories
]);

if (isset($_FILES)) {
    $lot_data['lot_img_url'] = 'img/lot-default.png';
}

if (isset($_FILES) && !empty($_FILES['lot_img']['size'])) {
    $uploaded = 'uploaded';
    $file = $_FILES['lot_img'];
    $allowed =
        [
            'jpeg' => 'image/jpeg',
            'png' => 'image/png'
        ];
    $validation_result = validateFile($file, $allowed);
    if (is_string($validation_result)) {
        $lot_upload_error = $validation_result;
    }
}

if (isset($_POST['lot_add'])) {
    foreach ($_POST as $key => $value)
    {
        if (in_array($key, $required) && (
            $value === '' || $value === 'Выберите категорию')) {
            $lot_errors[$key] = $lot_add_errors[$key]['error_message'];
        }
        if (array_key_exists($key, $rules) && $value !== '') {
            if (!empty($result = call_user_func($rules[$key], $value))) {
                $lot_errors[$key] = $result;
            };
        }
        $lot_data[$key] = $value;
        $lot_add_defaults[$key]['input'] = $value;
    }


    if (empty($lot_errors) && empty($lot_upload_error) && is_array(
        $validation_result)) {
        $destination_path =
            $validation_result['file_path'] . $validation_result['file_name'];
        $move_result = move_uploaded_file(
            $validation_result['file_name_tmp'], $destination_path);


        $lot_data['lot_img_url'] = $validation_result['file_url'];
    }

    if (empty($lot_errors) && (
        !empty($uploaded) && empty($lot_upload_error) || empty($uploaded))) {
        $lot = filterArray($lot_data, 'lot_add');

        $lot['user_id'] = $user_id;
        $lot['lot_date_end'] = convertDateMySQL($lot['lot_date_end']);

        $category_fetched = select_data_assoc($link, $category_id_sql,
            [$lot['lot_category']]);
        $category_id = $category_fetched[0]['category_id'];
        if(empty($category_id)) {
            echo 'Невозможно определить категорию для лота';
            die();
        }

        $lot_filtered = filterArray($lot, 'lot_category');
        $lot_filtered['category_id'] = $category_id;

        $lot_id = insert_data($link, 'lots',
            [
                'lot_name' => $lot_filtered['lot_name'],
                'lot_date_add' => $date_current->format('Y.m.d H:i:s'),
                'lot_date_end' => $lot_filtered['lot_date_end'],
                'lot_description' => $lot_filtered['lot_description'],
                'lot_img_url' => $lot_filtered['lot_img_url'],
                'lot_value' => $lot_filtered['lot_value'],
                'lot_step' => $lot_filtered['lot_step'],
                'user_id' => $lot_filtered['user_id'],
                'category_id' => $lot_filtered['category_id']
            ]);

        if (empty($lot_id)) {
            echo 'Невозможно добавить лот';
            die();
        }
        if (!empty($lot_id)) {
            header('Location: lot.php?lot_id=' . $lot_id);
        }
    }
}

$content = include_template('templates/add-lot.php',
    [
        'errors' => $lot_errors, 'upload_error' => $lot_upload_error,
        'categories' => $categories,
        'lot_name' => $lot_add_defaults['lot_name'],
        'lot_category' => $lot_add_defaults['lot_category'],
        'lot_description' => $lot_add_defaults['lot_description'],
        'lot_img' => $lot_add_defaults['lot_img'],
        'lot_value' => $lot_add_defaults['lot_value'],
        'lot_step' => $lot_add_defaults['lot_step'],
        'lot_date_end' => $lot_add_defaults['lot_date_end']

    ]);

$markup = new Markup('templates/layout.php',
    array_merge_recursive($layout,
        [
            'index' => $index, 'title' => $title,
            'nav' => $nav, 'content' => $content
        ]));
$markup->get_layout();

<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'data/data.php';
require 'data/form.php';
require 'data/errors.php';
require 'functions.php';

require 'markup/markup.php';
$form_data = [];
$errors = [];

$lot_name = $_POST['lot_name'] ?? '';
$lot_category = $_POST['lot_category'] ?? '';

$lot_description = $_POST['lot_description'] ?? '';
$lot_rate = $_POST['lot_rate'] ?? '';

$lot_step = $_POST['lot_step'] ?? '';
$lot_date = $_POST['lot_date'] ?? '';

$url_param = '';
$check_key = '';
$key = '';

$required = [
    'lot_name', 'lot_category',
    'lot_description', 'lot_rate', 'lot_step', 'lot_date'
];

$rules = [
    'lot_rate' => 'validateLotRate',
    'lot_step' => 'validateLotStep', 'lot_date' => 'validateDate'
];

if (isset($_POST['lot_add'])) {
    $check_key = 'lot_add';
}

if(isset($_POST['category'])) {
    $_POST['category'] === 'Выберите категорию' ?
        $_POST['category'] = '' : $_POST['category'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['lot_img'])) {

        $file = $_FILES['lot_img'];

        if ($file['error'] == 0) {
            $allowed = [
                'jpeg' => 'image/jpeg',
                'png' => 'image/png'
            ];

            $file_name = $file['name'];
            $file_name_tmp = $file['tmp_name'];

            $file_type = $file['type'];
            $file_size = $file['size'];

            $file_path = __DIR__ . '/img/';
            $file_url = 'img/' . $file_name;

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $file_type = finfo_file($finfo, $file_name);

            $result = validateUpload($allowed, $file_type, $file_size);

            if (!empty($result)) {
                $errors['lot_img'] = $result;
            }

            $destination_path = $file_path . $file_name;
            move_uploaded_file($file_name_tmp, $destination_path);


            $form_data['lot_img_url'] = $file_url;
            $form_data['lot_img_alt'] = $lot_name;

        } else {
            $errors['lot_img'] = $form_errors['lot_img']['error'];
        }
    }

    foreach ($_POST as $key => $value) {

        if (in_array($key, $required) && $value == '') {
            $errors[$key] = $form_errors[$key]['error'];
        }

        if (array_key_exists($key, $rules) && $value !== '') {
            $result = call_user_func($rules[$key], $value);

            if (!empty($result)) {
                $errors[$key] = $result;
            }

        } $form_data[$key] = $value;
    }
}

$index = false;
$nav = include_template('templates/nav.php', [
    'categories' => $categories
]);
$lot = $form_defaults['lot_add'];

var_dump($errors);
//if (empty($errors)) {
//    array_push($lots, $lot);
//
//    $lot_id = count($lots) - 1;
//    header('Location: lot.php?lot-id=' . $lot_id);
//}


$content = include_template('templates/add-lot.php',
    [
        'categories' => $categories,
        'errors' => $errors, 'lot_name' => $lot['lot_name'],
        'lot_category' => $lot['lot_category'],
        'lot_description' => $lot['lot_description'],
        'lot_img' => $lot['lot_img'], 'lot_value' => $lot['lot_value'],
        'lot_step' => $lot['lot_step'], 'lot_date' => $lot['lot_date']

    ]);

$markup = new Markup('templates/layout.php',
    array_merge_recursive($layout, [
        'content' => $content, 'index' => $index,
        'nav' => $nav
    ]));
$markup->get_layout();



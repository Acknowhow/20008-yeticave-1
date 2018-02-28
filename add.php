<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'data/data.php';
require 'data/form.php';
require 'data/errors.php';
require 'functions.php';

require 'markup/markup.php';

if(isset($_POST['lot_category'])) {
    $_POST['lot_category'] === 'Выберите категорию' ?
        $_POST['lot_category'] = '' : $_POST['lot_category'];
}

$form_data = [];
$errors = [];

$lot_name = $_POST['lot_name'] ?? '';
$lot_category = $_POST['lot_category'] ?? '';

$lot_description = $_POST['lot_description'] ?? '';
$lot_rate = $_POST['lot_rate'] ?? '';

$lot_step = $_POST['lot_step'] ?? '';
$lot_date = $_POST['lot_date'] ?? '';

$check_key = '';
$key = '';

$required = [
    'lot_name', 'lot_category',
    'lot_description', 'lot_value', 'lot_step', 'lot_date'
];
$rules = [
    'lot_value' => 'validateLotValue',
    'lot_step' => 'validateLotStep', 'lot_date' => 'validateDate'
];
$lot = $form_defaults['lot_add'];

if (isset($_POST['lot_add'])) {
    $check_key = 'lot_add';
}

if ($check_key === 'lot_add') {
    if (!empty($_FILES['lot_img']['size'])) {
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

        } $lot[$key]['input'] = $value;
    }

    if (empty($errors)) {
        $lot = $_POST;
        $lot['lot_img_url'] = $form_data['lot_img_url'];
        $lot['lot_img_alt'] = $form_data['lot_img_alt'];
        array_push($lots, $lot);
        $lot_id = count($lots) - 1;

        $_SESSION['lot_added'] = $lot;
        header('Location: lot.php?lot_id=' . $lot_id . '&&lot_added=true');
    }
}

$index = false;
$nav = include_template('templates/nav.php', [
    'categories' => $categories
]);

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


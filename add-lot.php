<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'defaults/add-lot.php';
require 'errors/add-lot.php';

require 'data/data.php';
require 'functions.php';

require 'markup/markup.php';

$lot_data = [];
$lot_errors = [];

$required = [
    'lot_name', 'lot_category',
    'lot_description', 'lot_value', 'lot_step', 'lot_date'
];
$rules = [
    'lot_value' => 'validateLotValue',
    'lot_step' => 'validateLotStep', 'lot_date' => 'validateDate'
];

//if ($_SERVER['REQUEST_METHOD'] == 'GET' && !isset($_SESSION['form_data']['user'])) {
//    http_response_code(403);
//    die();
//}

if (isset($_POST['lot_add'])) {
    if (!empty($_FILES['lot_img']['size'])) {
        $file = $_FILES['lot_img'];

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
            $lot_errors['lot_img'] = $result;
        }

        $destination_path = $file_path . $file_name;
        move_uploaded_file($file_name_tmp, $destination_path);


        $lot_data['lot_img_url'] = $file_url;
        $lot_data['lot_img_alt'] = $file_name;
    }

    foreach ($_POST as $key => $value) {
        if (in_array($key, $required) && ($value === '' || $value === 'Выберите категорию')) {
            $lot_errors[$key] = $lot_add_errors[$key]['error_message'];
        }

        if (array_key_exists($key, $rules) && $value !== '') {
            $result = call_user_func($rules[$key], $value);

            if (!empty($result)) {
                $lot_errors[$key] = $result;
            }

        } $lot_add_defaults[$key]['input'] = $value;
    }

    if (empty($lot_errors)) {
        $lot = $_POST;
        $lot['lot_img_url'] = $lot_data['lot_img_url'];
        $lot['lot_img_alt'] = $lot_data['lot_img_alt'];
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
        'categories' => $categories, 'errors' => $lot_errors,
        'lot_name' => $lot_add_defaults['lot_name'],
        'lot_category' => $lot_add_defaults['lot_category'],
        'lot_description' => $lot_add_defaults['lot_description'],
        'lot_img' => $lot_add_defaults['lot_img'],
        'lot_value' => $lot_add_defaults['lot_value'],
        'lot_step' => $lot_add_defaults['lot_step'],
        'lot_date' => $lot_add_defaults['lot_date']

    ]);

$markup = new Markup('templates/layout.php',
    array_merge_recursive($layout, [
        'content' => $content, 'index' => $index, 'nav' => $nav
    ]));
$markup->get_layout();


<?php
session_start();
require 'data/data.php';
require 'data/form.php';
require 'functions.php';

$form_data = [];
$errors = [];

$lot_name = $_POST['lot_name'] ?? '';
$lot_category = $_POST['lot_category'] === 'Выберите категорию' ?
    $_POST['lot_category'] = '' : $_POST['lot_category'];

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

        if (array_key_exists($key, $rules)) {
            $result = call_user_func($rules[$key], $value);

            if (!empty($result)) {
                $errors[$key] = $result;
            }

        } $form_data[$key] = $value;
    }
}

if (!empty($check_key)) {

    foreach ($form_data as $key => $value) {
        $form_defaults[$check_key][$key]['input'] = $value ? $value : '';
    }
}

$result = count($errors[$check_key]) ? 'false' : 'true';
$url_param = "is_added=" . $result;

header('Location: index.php?' . $url_param);

<?php
session_start();
require 'data/add-lot.php';
require 'data/data.php';
require 'functions.php';

$form_data = [];
$users = [];
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
    'lot_name', 'lot_category', 'lot_description',
    'lot_rate', 'lot_step', 'lot_date'
];

$rules = [
    'lot_rate' => 'validateLotRate',
    'lot_step' => 'validateLotStep', 'lot_date' => 'validateDate'
];

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
                $errors['lot_file_error'] = $result;
            }

            $destination_path = $file_path . $file_name;
            move_uploaded_file($file_name_tmp, $destination_path);


            $form_data['lot_img_url'] = $file_url;
            $form_data['lot_img_alt'] = 'uploaded';

        } else {
            $errors['lot_file_error'] = $add['lot_file']['lot_error'];

        }
    }

    foreach ($_POST as $key => $value) {

        if (in_array($key, $required) && $value == '') {
            $errors[$key] = $add[$key]['lot_error'];
        }

        if (array_key_exists($key, $rules)) {
            $result = call_user_func($rules[$key], $value);

            if (!empty($result)) {
                $errors[$key] = $result;
            }

        } $form_data[$key] = $value;
    }
}

$_SESSION['form_data'] = $form_data;
$_SESSION['errors'] = $errors;


$result = count($errors[$check_key]) || isset($errors['lot_file_error']) ?
    'false' : 'true';
$url_param = "is_added=" . $result;

header('Location: index.php?' . $url_param);

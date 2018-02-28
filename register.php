<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'defaults/register.php';
require 'errors/register.php';

require 'data/data.php';
require 'functions.php';

require 'markup/markup.php';
$user_data = [];
$user_errors = [];

$required = [
    'user_name', 'user_email',
    'user_password', 'user_contacts'
];
$rules = [
    'email' => 'validateEmail', 'password' => 'validatePassword'
];
if (isset($_FILES)) {
    $uploaded = !empty($_FILES['user_img']['size']) ? 'uploaded': '';
}

if (isset($_POST['register'])) {

    foreach ($_POST as $key => $value) {
        if (in_array($key, $required) && $value == '') {
            $user_errors[$key] = $register_errors[$key]['error_message'];
        }
        if (array_key_exists($key, $rules) && $value !== '') {
            $result = call_user_func($rules[$key], $value);

            if (!empty($result)) {
                $user_errors[$key] = $result;
            }

        } $register_defaults[$key]['input'] = $value;
    }

    if (empty($user_errors) && !empty($uploaded)) {
        $file
    }
}

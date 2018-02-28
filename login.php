<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'defaults/login.php';
require 'errors/login.php';

require 'data/data.php';
require 'functions.php';

require 'markup/markup.php';

$required = [
    'user_email', 'user_password'
];

$rules = [
    'user_email' => 'validateEmail', 'user_password' => 'validatePassword'
];

if (isset($_POST['login'])) {
    foreach ($_POST as $key => $value) {
        if (in_array($key, $required) && ($value === '')) {
            $login_errors[$key] = $user_login_errors[$key]['error_message'];
        }

        if (array_key_exists($key, $rules) && $value !== '') {
            $result = call_user_func($rules[$key], $value);

            if (!empty($result)) {
                $login_errors[$key] = $result;
            }
        } $login_defaults[$key]['input'] = $value;
    }
}

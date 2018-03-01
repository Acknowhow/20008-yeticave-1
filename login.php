<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'defaults/login.php';
require 'errors/login.php';

require 'data/data.php';
require 'functions.php';

require 'markup/markup.php';

$user_data = [];
$user_errors = [];

$required = [
    'user_email', 'user_password'
];

$rules = [
    'user_email' => 'validateEmail', 'user_password' => 'validatePassword'
];

$email_check = '';
$password_check = '';


if (isset($_POST['login'])) {
    foreach ($_POST as $key => $value) {
        if (in_array($key, $required) && ($value === '')) {
            $login_errors[$key] = $user_login_errors[$key]['error_message'];

            $login_defaults[$key]['input'] = $value;
        } elseif ($key === 'user_email' && $value !== '') {
            $email_check = call_user_func($rules[$key], $value);
        } elseif ($key === 'user_password' && $value !== '') {
            $password_check = call_user_func(
                'validateUser', $_POST['user_email'],
                $users, $_POST['user_password']);
        }

        if (!empty($email_check)) {
            $login_errors['user_email'] = $email_check;
        }

        if (is_string($password_check)) {
            $login_errors['user_password'] = $password_check;
        }

        if (is_array($password_check)) {
            $user_data = $password_check;
        }


    }
}

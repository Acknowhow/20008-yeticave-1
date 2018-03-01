<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'defaults/login.php';
require 'errors/login.php';

require 'data/data.php';
require 'data/users.php';
require 'functions.php';

require 'markup/markup.php';


$user = [];
$user_errors = [];

$user_email = isset($_POST['user_email']) ?
    $_POST['user_email'] : '';
$user_password = isset($_POST['user_password']) ?
    $_POST['user_password'] : '';

$required = [
    'user_email', 'user_password'
];

$rules = [
    'user_email' => 'validateEmail', 'user_password' => 'validateUser'
];

$email_check = '';
$password_check = '';

if (isset($_POST['login'])) {
    foreach ($_POST as $key => $value) {

        if (in_array($key, $required) && ($value === '')) {
            $user_errors[$key] = $user_login_errors[$key]['error_message'];

        }
        $login_defaults[$key]['input'] = $value;
    }

    if(!empty($user_email) && !empty($email_check = call_user_func(
        'validateEmail', $user_email))) {
        $user_errors['user_email'] = $email_check;
    }

    if(!empty($user_password) && is_string(
        $password_check = call_user_func('validateUser',
            $user_email, $users, $user_password))) {

        $user_errors['user_password'] = $password_check;
    }

    if(!empty($user_password) && is_array(
            $password_check = call_user_func('validateUser',
                $user_email, $users, $user_password))) {

        $user = $password_check;
    }


    if (empty($user_errors)) {
        $_SESSION['user'] = $user;
        header('Location: index.php?is_auth=true');
    }
}
$index = false;
$nav = include_template('templates/nav.php', [
    'categories' => $categories
]);

$content = include_template('templates/login.php',
    [
        'user_email' => $login_defaults['user_email'],
        'user_password' => $login_defaults['user_password'],
        'errors' => $user_errors
    ]);

$markup = new Markup('templates/layout.php',
    array_merge_recursive($layout, [
        'content' => $content, 'index' => $index, 'nav' => $nav
    ]));
$markup->get_layout();

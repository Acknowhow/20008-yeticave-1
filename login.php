<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'resource/functions.php';


require_once 'init.php';
require 'database/database.php';

require 'markup/markup.php';
$user = [];
$errors = [];

$email = isset($_POST['email']) ?
    $_POST['email'] : '';
$password = isset($_POST['password']) ?
    $_POST['password'] : '';

$required = [
    'email', 'password'
];
$rules = [
    'email' => 'validateEmail', 'password' => 'validateUser'
];

$login_defaults = [
    'email' => [
        'name' => 'email', 'title' => 'E-mail*',
        'input' => '', 'placeholder' => 'Введите e-mail'
    ],
    'password' => [
        'name' => 'password', 'title' => 'Пароль*',
        'input' => '', 'placeholder' => 'Введите пароль'
    ]
];
$login_errors = [
    'email' => [
        'name' => 'email', 'error_message' => 'Введите email'
    ],
    'password' => [
        'name' => 'password', 'error_message' => 'Введите пароль'
    ]

];

$users_sql = 'SELECT id,name,email,
password,avatar_path FROM users ORDER BY id ASC;';

$users = select_data_assoc($link, $users_sql, []);
$email_check = '';

$password_check = '';
$index = false;

$nav = includeTemplate('templates/nav.php',
    [
        'categories' => $categories
    ]);

if (isset($_POST['login']))
{
    foreach ($_POST as $key => $value)
    {
        if (in_array($key, $required) && ($value === ''))
        {
            $errors[$key] = $login_errors[$key]['error_message'];
        }
        $login_defaults[$key]['input'] = $value;
    }

    if (!empty($email) && !empty($email_check = call_user_func(
        'validateEmail', $email)))
    {
        $errors['email'] = $email_check;
    }

    if (!empty($password) && is_string(
        $password_check = call_user_func(
            'validateUser', $email, $users, $password)))
    {
        $errors['password'] = $password_check;
    }

    if (!empty($password) && is_array(
        $password_check = call_user_func(
            'validateUser', $email, $users, $password)))
    {
        $_SESSION['user'] = $password_check;
        header('Location: index.php');
    }
}

$content = includeTemplate('templates/login.php',
    [
        'email' => $login_defaults['email'],
        'password' => $login_defaults['password'],
        'errors' => $errors
    ]);
$markup = new Markup('templates/layout.php', array_merge_recursive(
    $layout,
    [
        'index' => $index, 'title' => $title,
        'nav' => $nav, 'content' => $content, 'search' => $search
    ]));
$markup->get_layout();

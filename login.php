<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'resource/functions.php';

require 'defaults/login.php';
require 'errors/login.php';

require_once 'init.php';
require 'data/data.php';

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

$users_sql = 'SELECT id,name,email,
password,avatar_path FROM users ORDER BY id ASC;';

$users = select_data_assoc($link, $users_sql, []);
$email_check = '';

$password_check = '';
$index = false;

$nav = include_template('templates/nav.php',
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

$content = include_template('templates/login.php',
    [
        'email' => $login_defaults['email'],
        'password' => $login_defaults['password'],
        'errors' => $errors
    ]);
$markup = new Markup('templates/layout.php', array_merge_recursive(
    $layout,
    [
        'index' => $index, 'title' => $title,
        'nav' => $nav, 'content' => $content
    ]));
$markup->get_layout();

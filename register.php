<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'resource/functions.php';

require 'defaults/register.php';
require 'errors/register.php';

require_once 'init.php';
require 'data/data.php';

require 'markup/markup.php';
$index = false;
$title = 'Регистрация пользователя';
$user_data = [];
$user_errors = [];

$email = isset($_POST['email']) ?
    $_POST['email'] : '';
$password = isset($_POST['password']) ?
    $_POST['password'] : '';

$uploaded = '';
$user_upload_error = '';
$validation_result = '';
$user_id = null;

$required = [
    'name', 'email',
    'password', 'contacts'
];
$nav = include_template('templates/nav.php',
    [
        'categories' => $categories
    ]
);
$users_sql = 'SELECT email,password,name 
FROM users ORDER BY id ASC;';

$users = select_data_assoc($link, $users_sql, []);

if (isset($_FILES) && !empty($_FILES['avatar_path']['size'])) {
    $uploaded = 'uploaded';

    $file = $_FILES['avatar_path'];
    $allowed = [
        'jpeg' => 'image/jpeg',
        'png' => 'image/png'
    ];
    $validation_result = validateFile($file, $allowed);
    if (is_string($validation_result)) {
        $user_upload_error = $validation_result;
    }
}

if (isset($_POST['register'])) {

    foreach ($_POST as $key => $value) {

        if (in_array($key, $required) && $value == '') {
            $user_errors[$key] = $register_errors[$key]['error_message'];
        }
        $user_data[$key] = $value;
        $register_defaults[$key]['input'] = $value;
    }

    if (!empty($_POST['email'])) {
        if (!empty($result = call_user_func(
            'validateEmail', $email)) ||

            !empty($result = call_user_func(
                'searchUserByEmail',

                $email, $users, true))) {
            $user_errors['email'] = $result;
        }
    }

    if (!empty($_POST['password'])) {
        if (is_string($result = call_user_func(

            'validatePassword', $password))) {
            $user_errors['password'] = $result;
        }
        elseif (is_array($password = call_user_func(
            'validatePassword', $password))) {
            $user_data['password'] = $password[0];
        }
    }

    if (empty($user_errors) && empty($user_upload_error) &&
        is_array($validation_result)) {

        $destination_path = $validation_result['file_path'] .
        $validation_result['file_name'];

        move_uploaded_file(
            $validation_result['file_name_tmp'], $destination_path);
        $user_data['avatar_path'] = $validation_result['file_url'];
    }

    if (empty($user_errors) && (
        !empty($uploaded) && empty($user_upload_error) || empty($uploaded))) {
        $user = filterArrayByKey($user_data, 'register');

        $user['avatar_path'] = $user_data['avatar_path'] ?? 'img/user.jpg';
        $user_id = insert_data($link, 'users',
            [
                'name' => $user['name'],
                'email' => $user['email'],

                'password' => $user['password'],
                'avatar_path' => $user['avatar_path'],
                'contacts' => $user['contacts']
            ]);
        if(!$user_id) {
            print 'Can\'t get user_id';
            exit();
        }
        $user['id'] = $user_id;
        $_SESSION['user'] = $user;
        header('Location: index.php');
    }
}

$content = include_template(
    'templates/register.php',
    [
        'errors' => $user_errors, 'upload_error' => $user_upload_error,
        'name' => $register_defaults['name'], 'email' =>

         $register_defaults['email'], 'password' =>
         $register_defaults['password'], 'contacts' =>

         $register_defaults['contacts'], 'avatar_path' =>
         $register_defaults['avatar_path']
    ]
);

$markup = new Markup(
    'templates/layout.php', array_merge_recursive(
        $layout,
        [
            'index' => $index, 'title' => $title,
            'nav' => $nav, 'content' => $content
        ]
    )
);
$markup->get_layout();

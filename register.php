<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'functions.php';

require 'defaults/register.php';
require 'errors/register.php';

require 'init.php';
require 'data/data.php';

require 'markup/markup.php';
$user_data = [];
$user_errors = [];

$user_email = isset($_POST['user_email']) ? $_POST['user_email'] : '';
$user_password = isset($_POST['user_password']) ? $_POST['user_password'] : '';

$uploaded = '';
$user_upload_error = '';

$required = [
    'user_name', 'user_email',
    'user_password', 'user_contacts'
];
if (isset($_FILES)) {
    $uploaded = !empty($_FILES['user_img']['size']) ? 'uploaded': '';
}

if (isset($_POST['register'])) {

    foreach ($_POST as $key => $value) {
        if (in_array($key, $required) && $value == '') {
            $user_errors[$key] = $register_errors[$key]['error_message'];
        }
        $register_defaults[$key]['input'] = $value;
    }

    if (!empty($_POST['user_email'])) {
        if (!empty($result = call_user_func('validateEmail', $user_email)) ||
            !empty($result = call_user_func('searchUserByEmail', $user_email, $users, true))) {

            $user_errors['user_email'] = $result;
        }
    }

    if (!empty($_POST['user_password'])) {
        if (is_string($result = call_user_func('validatePassword', $user_password))){
            $user_errors['user_password'] = $result;

        }
        elseif (is_array($password = call_user_func('validatePassword', $user_password))){
            $_POST['user_password'] = $password[0];
        }
    }

    if (empty($user_errors) && !empty($uploaded)) {
        $file = $_FILES['user_img'];
        $allowed = [
            'jpeg' => 'image/jpeg',
            'png' => 'image/png'
        ];

        $result = validateFile($file, $allowed);

        if (is_string($result)) {
            $user_upload_error = $result;

        } elseif (is_array($result)) {
            $destination_path =
                $result['file_path'] . $result['file_name'];
            move_uploaded_file(
                $result['file_name_tmp'],
                $destination_path);

            $user_data['user_img_url'] = $result['file_url'];
            $user_data['user_img_alt'] = $result['file_name'];

        }
    }

    if (empty($user_errors) && empty($user_upload_error)) {
        $user = $_POST;
        $user['user_img_url'] = $user_data['user_img_url'];
        $user['user_img_alt'] = $user_data['user_img_alt'];
        array_push($users, $user);
        $user_id = count($users) - 1;

        $_SESSION['user'] = $user;
        header('Location: index.php');
    }

}
$index = false;
$nav = include_template('templates/nav.php', [
    'categories' => $categories
]);

$content = include_template('templates/register.php',
    [
        'errors' => $user_errors, 'upload_error' => $user_upload_error,
        'user_name' => $register_defaults['user_name'], 'user_email' =>
         $register_defaults['user_email'], 'user_password' =>
         $register_defaults['user_password'], 'user_contacts' =>
         $register_defaults['user_contacts'], 'user_img' =>
         $register_defaults['user_img']
    ]);

$markup = new Markup('templates/layout.php',
    array_merge_recursive($layout,
        [
            'index' => $index,
            'nav' => $nav, 'content' => $content
        ]));
$markup->get_layout();

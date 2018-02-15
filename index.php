<?php

require 'functions.php';
require 'config.php';
require 'data.php';

error_reporting(-1);
ini_set("display_errors", 1);

$content = include_template('templates/index.php', [
    'categories' => $categories, 'lots' => $lots]);

print include_template('templates/layout.php', [
    'content' => $content, 'title' => $title, 'is_auth' => $is_auth,

    'user_avatar' => $user_avatar, 'user_name' => $user_name, 'categories' => $categories
]);




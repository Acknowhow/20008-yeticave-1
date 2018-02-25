<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

session_start();
require 'functions.php';
require 'data/add-lot.php';
require 'data/data.php';

$form_data = [];
$users = [];
$errors = [];
$errors_upload = [];

$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$contacts = isset($_POST['contacts']) ? $_POST['contacts'] : '';

$category = isset($_POST['category']) ? $_POST['category'] : '';
$step = isset($_POST['step']) ? $_POST['step'] : '';
$bet = isset($_POST['bet']) ? $_POST['bet'] : '';

$bet_id = isset($_POST['bet_id']) ? $_POST['bet_id'] : '';
$date_end = isset($_POST['date_end']) ? $_POST['date_end'] : '';

$url_param = '';
$check_key = '';
$key = '';

if(isset($_POST['category'])) {
    $_POST['category'] === 'Выберите категорию' ?
        $_POST['category'] = '' : $_POST['category'];
}

$required = [
    'lot_name', 'category', 'message',
    'lot_rate', 'lot_step', 'lot_date'
];

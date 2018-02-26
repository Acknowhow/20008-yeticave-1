<?php
session_start();
require 'data/add-lot.php';
require 'data/data.php';
require 'functions.php';

$form_data = [];
$users = [];
$errors = [];
$errors_upload = [];

$lot_name = $_POST['lot_name'] ?? '';
$category = $_POST['category'] === 'Выберите категорию' ?
    $_POST['category'] = '' : $_POST['category'];

$message = $_POST['message'] ?? '';
$lot_rate = $_POST['lot_rate'] ?? '';

$lot_step = $_POST['lot_step'] ?? '';
$lot_date = $_POST['lot_date'] ?? '';

$url_param = '';
$check_key = '';
$key = '';

$required = [
    'lot_name', 'category', 'message',
    'lot_rate', 'lot_step', 'lot_date'
];


$rules = [
    'lot_rate' => 'validateLotRate',
    'lot_step' => 'validateLotStep', 'lot_date' => 'validateDate'
];

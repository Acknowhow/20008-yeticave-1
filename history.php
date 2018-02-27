<?php
session_start();
$cookie_value = isset($_COOKIE['lot_visited']) ?
    $_COOKIE['lot_visited'] : '';

var_dump($cookie_value);

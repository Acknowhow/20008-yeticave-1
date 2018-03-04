<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'functions.php';

require_once 'init.php';
require 'data/data.php';

require 'markup/markup.php';




$cookie_bet_value = isset($_COOKIE['cookie_bet']) ?
$_COOKIE['cookie_bet'] : '';

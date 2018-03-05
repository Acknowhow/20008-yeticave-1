<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'util/functions.php';

require_once 'init.php';
require 'data/data.php';

require 'markup/markup.php';

if(isset($_POST['cost']))
{
    $lot_id = $_POST['lot_id'];
    $user_id = $_POST['user_id'];
    $bet_value = $_POST['bet_value'];

    $res1 =
}

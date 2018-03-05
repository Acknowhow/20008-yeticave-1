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

    mysqli_query($link, 'START TRANSACTION');

    $bet_id_res = insert_data($link, 'bets',
        [
            'lot_id' => $lot_id,
            'bet_value' => $bet_value, 'user_id' => $user_id
        ]);

    $lot_update_sql = "UPDATE lots SET lot_value=lot_value + '".$bet_value."' WHERE lot_id=?";
    $lot_update_res = exec_query($link, $lot_update_sql, [$lot_id]);

    if ($lot_update_sql && $lot_update_res) {
        mysqli_query($link, "COMMIT");
    } else {
        mysqli_query($link, "ROLLBACK");
    }

}

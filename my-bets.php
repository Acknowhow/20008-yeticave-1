<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'util/functions.php';

require_once 'init.php';
require 'data/data.php';

require 'markup/markup.php';
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['user_id'])) {
    http_response_code(403);
    exit('Вы не авторизованы ' . http_response_code() . '');
}

$user_id = $_SESSION['user']['user_id'];
$lot_id = $_POST['lot_id'] ?? null;

$bet_value = $_POST['bet_value'] ?? null;

$lot_value = $_POST['lot_value'] ?? null;
$lot_step = $_POST['lot_step'] ?? null;
$lot_min = $lot_value + $lot_step;

if (!isset($bet_value)) {
    $content = include_template('templates/my-bets.php',
        [
            'lots' => $lots
        ]
    );
}

$validate = validateBetValue($bet_value, $lot_min);

if (!empty($validate)) {
    $_SESSION['user'][$user_id]['bet_error'] = $validate;
    header('Location: lot.php?lot_id=' . $lot_id);
}

elseif (empty($validate)) {
    $lot_update_sql = "UPDATE lots SET lot_value=? WHERE lot_id=?";

    mysqli_query($link, 'START TRANSACTION');
    $bet_id_res = insert_data($link, 'bets',
        [
            'lot_id' => $lot_id,
            'bet_value' => $bet_value, 'user_id' => $user_id
        ]
    );

    $lot_update_res = update_data($link, $lot_update_sql,
        [
            'lot_value' => $bet_value,
            'lot_id' => $lot_id
        ]
    );

    if ($bet_id_res && $lot_update_res) {
        mysqli_query($link, "COMMIT");
        header('Location: lot.php?lot_id=' . $lot_id);
    } else {
        mysqli_query($link, "ROLLBACK");
    }
}

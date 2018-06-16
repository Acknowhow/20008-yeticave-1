<?php
session_start();
require_once 'vendor/autoload.php';

require 'defaults/config.php';
require 'defaults/var.php';
require 'resource/functions.php';

require_once 'database/database.php';

if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
    http_response_code(403);
    exit('Вы не авторизованы ' . http_response_code() . '');
}

$user_id = $_SESSION['user']['id'];

// Select lots which are due date and not won
// by other users
$winning_lots_sql = 'SELECT b.lot_id,user_id,b.value
FROM bets b
JOIN (SELECT id,date_end,bet_wins,MAX(value) AS value
      FROM lots 
      GROUP BY id) AS l
      ON b.lot_id = l.id AND b.value = l.value
      WHERE UNIX_TIMESTAMP(l.date_end) < UNIX_TIMESTAMP(NOW())
      AND l.bet_wins = 0';

$dbHelper->executeQuery($winning_lots_sql);

if ($dbHelper->getLastError()) {
    print $dbHelper->getLastError();

} else {
    $winning_lots = $dbHelper->getAssocArray();
}



if ($winning_lots) {
    $winner_lots = array_values(filterArrayById(
        $winning_lots, 'user_id', intval($user_id)));

    if (!$winner_lots) {
        $_SESSION['user']['winner_check'] = 'checked';
        header('Location:index.php');
    }


    foreach ($winner_lots as $winner_lot) {
        $winner_lot_update_sql = '
        UPDATE lots SET bet_wins=1 WHERE id=' . $winner_lot['lot_id'];

        $dbHelper->executeQuery($winner_lot_update_sql);
        if ($dbHelper->getLastError()) {
            print $dbHelper->getLastError();
        }
    }
}
$_SESSION['user']['winner_check'] = 'checked';
header('Location:index.php');





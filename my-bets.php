<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'resource/functions.php';

require 'database/database.php';
require 'markup/markup.php';

if (!isset($_SESSION['user']) ||
    !isset($_SESSION['user']['id'])) {
    http_response_code(403);
    exit('Вы не авторизованы ' . http_response_code() . '');
}
$user_id = $_SESSION['user']['id'];

$lot_id = $_POST['lot_id'] ?? null;

$bet_value = $_POST['bet_value'] ?? null;

$lot_value = $_POST['lot_value'] ?? null;
$lot_step = $_POST['lot_step'] ?? null;
$lot_min = $lot_value + $lot_step;

$validate = '';
$_POST = [];

var_dump($bet_value);

if (!isset($bet_value)) {
    $index = false;
    $title = 'Мои ставки';

    $my_bets_sql = '
    SELECT 
      b.value, UNIX_TIMESTAMP(b.date_add),b.user_id,
      IF(UNIX_TIMESTAMP(l.date_end) < UNIX_TIMESTAMP(NOW()),1,0) 
      AS bet_wins,l.id AS lot_id,l.name AS lot_name,
      UNIX_TIMESTAMP(l.date_end),l.lot_path,c.name 
      AS lot_category,u.contacts 
    FROM bets b 
    JOIN (lots l JOIN categories c ON l.category_id=c.id) 
    ON l.id = b.lot_id JOIN users u ON u.id=l.user_id 
    AND b.user_id=? ORDER BY b.date_add DESC';

    $dbHelper->executeQuery($my_bets_sql, [$user_id]);

    if ($dbHelper->getLastError()) {
        print $dbHelper->getLastError();

    } else {
        $my_bets = $dbHelper->getAssocArray();
    }

    $nav = includeTemplate('templates/nav.php',
        [
            'categories' => $categories
        ]);

    $content = includeTemplate('templates/my-bets.php',
        [
            'my_bets' => $my_bets
        ]
    );
    $markup = new Markup(
        'templates/layout.php', array_merge_recursive(
            $layout,
            [
                'index' => $index, 'title' => $title,
                'nav' => $nav, 'content' => $content, 'search' => $search
            ]
        )
    );
    $markup->get_layout();
}

if (isset($bet_value)) {
    $validate = validateBetValue($bet_value, $lot_min);

    if (!empty($validate)) {
        $_SESSION['user'][$user_id]['bet_error'] = $validate;
        header('Location: lot.php?lot_id=' . $lot_id);
    }
    $bet_insert_sql = '
    INSERT INTO
     bets (lot_id,value,date_add,user_id) 
    VALUES (?,?,?,?)';

    $lot_update_sql = '
    UPDATE lots SET value=? WHERE id=?';

    var_dump($dbHelper);
    $dbHelper->makeTransaction(
        $bet_insert_sql, [

        'lot_id' => $lot_id, 'value' => $bet_value,
        'date_add' => $date_current->format('Y.m.d H:i:s'),
        'user_id' => $user_id
        ],

        $lot_update_sql, [
        'value' => $bet_value,
        'id' => $lot_id
        ]
    );
    if ($dbHelper->getLastError()) {
        print $dbHelper->getLastError();

    } else {
        header('Location: lot.php?lot_id=' . $lot_id);
    }

//    mysqli_query($link, 'START TRANSACTION');
//    $bet_id_res = insert_data($link, 'bets',
//        [
//            'lot_id' => $lot_id, 'value' => $bet_value,
//            'date_add' => $date_current->format('Y.m.d H:i:s'),
//            'user_id' => $user_id
//        ]
//    );
//
//    $lot_update_res = update_data($link, $lot_update_sql,
//        [
//            'value' => $bet_value,
//            'id' => $lot_id
//        ]
//    );

//    if ($bet_id_res && $lot_update_res) {
//        mysqli_query($link, 'COMMIT');
//        header('Location: lot.php?lot_id=' . $lot_id);
//    } else {
//        mysqli_query($link, 'ROLLBACK');
//    }
}




<?php
// Some dynamic logic goes here
$lot_id = isset($_GET['lot-id']) ? $_GET['lot-id'] : null;


//if (isset($lot_($lot_id)) {
//}


    if (!isset($lots[$lot_id])) {
        http_response_code(404);
        $content = include_template('templates/404.php',
            [
                'container' => $container
            ]);
    } else {
        $lot = $lots[$lot_id];
        $content = include_template('templates/lot.php',

            [
                'categories' => $categories, 'bets' => $bets,
                'lot_name' => $lot['lot_name'], 'lot_category' => $lot['lot_category'],

                'lot_value' => $lot['lot_value'], 'lot_img_url' => $lot['lot_img_url'],
                'lot_img_alt' => $lot['lot_img_alt'], 'lot_description' => $lot['lot_description']
            ]);

    }


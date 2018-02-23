<?php
// Some dynamic logic goes here
$lot_id = isset($_GET['lot-id']) ? $_GET['lot-id'] : null;

class Lot {
    var $lot_id;

    // Sets id derived from $_GET['id']
    function set_id($new_id) {
        $this->lot_id = $new_id;
    }


    function get_id($new_id) {
        return $this->lot_id = $new_id;
    }
}
class myLot{

}


if (isset($_GET['id'])) {
    $index = false;
    $title = $error_title;

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
}

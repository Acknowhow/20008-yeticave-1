<?php
session_start();
require 'defaults/config.php';
require 'defaults/var.php';
require 'functions.php';

require 'defaults/add-lot.php';
require 'errors/add-lot.php';

require_once 'init.php';
require 'data/data.php';

require 'markup/markup.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET' && (
    !isset($_SESSION['user']) || !isset($_SESSION['user']['user_id']))) {
    http_response_code(403);
    exit('Access forbidden ' . http_response_code() . '');
}
$lot_data = [];
$lot_errors = [];

$uploaded = '';
$lot_upload_error = '';

$user_id = $_SESSION['user']['user_id'];

$required = [
    'lot_name', 'lot_category',
    'lot_description', 'lot_value', 'lot_step', 'lot_date_end'
];
$rules = [
    'lot_value' => 'validateLotValue',
    'lot_step' => 'validateLotStep', 'lot_date_end' => 'validateDate'
];

$category_id_sql = 'SELECT category_id FROM categories WHERE category_name=?';

if (isset($_FILES)) {
    $uploaded = !empty($_FILES['lot_img']['size']) ? 'uploaded': '';
}

if (isset($_POST['lot_add'])) {
    foreach ($_POST as $key => $value) {
        if (in_array($key, $required) && ($value === '' || $value === 'Выберите категорию')) {
            $lot_errors[$key] = $lot_add_errors[$key]['error_message'];
        }

        if (array_key_exists($key, $rules) && $value !== '') {

            if (!empty($result = call_user_func($rules[$key], $value))) {
                $lot_errors[$key] = $result;
            };

        }

        $lot_add_defaults[$key]['input'] = $value;
    }

    if (!empty($uploaded)) {
        $file = $_FILES['lot_img'];
        $allowed = [
            'jpeg' => 'image/jpeg',
            'png' => 'image/png'
        ];

        $result = validateFile($file, $allowed);

        if (is_string($result)) {
            $user_upload_error = $result;

        } elseif (is_array($result)) {
            $destination_path =
                $result['file_path'] . $result['file_name'];
            move_uploaded_file(
                $result['file_name_tmp'],
                $destination_path);

            $lot_data['lot_img_url'] = $result['file_url'];
        }
    }

    if (empty($lot_errors)) {
        $lot = filterArray($_POST, 'lot_add');

        $lot['lot_date_end'] = convertDateMySQL($lot['lot_date_end']);

        $category_fetched = select_data_assoc($link, $category_id_sql, [$lot['lot_category']]);
        $category_id = $category_fetched[0]['category_id'];

        $lot['lot_category'] = $category_id;


//        if(!empty($uploaded) && empty($lot_upload_error)) {
//            $lot['lot_img_url'] = $lot_data['lot_img_url'];
//        }
//
//        if (empty($uploaded)) {
//            $lot['lot_img_url'] = 'img/Moment-Generator-Web-Render-ZB.jpg';
//        }
//
//        var_dump($category_id['category_id']);
//
//        var_dump($filtered);
//
//
//
//        $lot_id = insert_data($link, 'lots',
//            [
//                'lot_name' => $filtered['lot_name'],
//                'lot_date_end' => $filtered['lot_date_end'],
//                'lot_img_url' => $filtered['lot_img_url'],
//                'lot_value' => $filtered['lot_value'],
//                'lot_step' => $filtered['lot_step'],
//                'user_id' => $user_id,
//                'category_id' => $category_id
//            ]);

    }

}



//if (empty($result = call_user_func('isEmptyArray', $lot_data)))
//
//
//    var_dump(array_values($_POST));


//
//    if (!empty($_FILES['lot_img']) && !empty($lot_data['lot_img_url'])) {
//        $lot['lot_img_url'] = $lot_data['lot_img_url'];
//    }
//
//    if (empty($lot_errors) && (empty($_FILES['lot_img']) ||
//            !empty($_FILES['lot_img']) && empty($lot_upload_error))) {
//
//        $lot = $_POST;
//        $lot['lot_date_end'] = convertTimeStampMySQL($lot['lot_date_end']);
//        $category_id = select_data_assoc($link, $category_id_sql, [$lot['lot_category']]);
//
//        $lot_id = insert_data($link, 'lots',
//            [
//                'lot_name' => $lot['lot_name'],
//                'lot_date_end' => $lot['lot_date_end'],
//                'lot_img_url' => $lot['lot_img_url'],
//                'lot_value' => $lot['lot_value'],
//                'lot_step' => $lot['lot_step'],
//                'user_id' => $user_id,
//                'category_id' => $category_id
//            ]);
//
//        if (empty($lot_id)) {
//
//            print 'This sucks';
//        }
//        if (!empty($lot_id)) {
//
//            $_SESSION['lot_added'] = $lot;
//            $_SESSION['lot_added']['lot_id'] = $lot_id;
//
//            header('Location: lot.php?lot_id=' .
//                $lot_id . '&&lot_added=true');
//
//        }
//
//
//    }
//}

$index = false;
$nav = include_template('templates/nav.php', [
    'categories' => $categories
]);

$content = include_template('templates/add-lot.php',
    [
        'categories' => $categories, 'errors' => $lot_errors,
        'upload_error' => $lot_upload_error,
        'lot_name' => $lot_add_defaults['lot_name'],
        'lot_category' => $lot_add_defaults['lot_category'],
        'lot_description' => $lot_add_defaults['lot_description'],
        'lot_img' => $lot_add_defaults['lot_img'],
        'lot_value' => $lot_add_defaults['lot_value'],
        'lot_step' => $lot_add_defaults['lot_step'],
        'lot_date_end' => $lot_add_defaults['lot_date_end']

    ]);

$markup = new Markup('templates/layout.php',
    array_merge_recursive($layout,
        [
            'index' => $index,
            'nav' => $nav, 'content' => $content
        ]));
$markup->get_layout();


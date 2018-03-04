<?php
//TODO: each error message should be assigned to error type correspondingly
//
$lot_add_errors = [
    'lot_name' => [
        'name' => 'lot_name', 'error_message' => 'Введите наименование лота'
    ],
    'lot_category' => [
        'name' => 'lot_category', 'error_message' => 'Выберите категорию'
    ],
    'lot_description' => [
        'name' => 'lot_description', 'error_message' => 'Добавьте описание лота'
    ],
    'lot_value' => [
        'name' => 'lot_value', 'error_message' => 'Введите начальную цену'
    ],
    'lot_step' => [
        'name' => 'lot_step', 'error_message' => 'Введите шаг ставки'
    ],
    'lot_date_end' => [
        'name' => 'lot_date_end', 'error_message' => 'Введите дату завершения торгов'
    ]
    // TODO
    //'error_empty' => 'Введите дату завершения торгов',
    //'error_format' => 'Неправильный формат даты', 'error_date' => 'Дата меньше текущего значения'
];

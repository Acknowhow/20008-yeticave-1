<?php
$form_defaults = [
    'lot_add' => [
        'lot_name' => [
            'name' => 'lot_name', 'title' => 'Наименование',
            'input' => '', 'placeholder' => 'Введите наименование лота'
        ],
        'lot_category' => [
            'name' => 'lot_category',
            'title' => 'Категория', 'input' => 'Выберите категорию'
        ],
        'lot_description' => [
            'name' => 'lot_description', 'title' => 'Описание',
            'input' => '', 'placeholder' => 'Добавьте описание лота'
        ],
        'lot_img' => [
            'name' => 'lot_img', 'title' => 'Изображение',
            'lot_img_alt' => 'Изображение лота', 'input' => ''
        ],
        'lot_value' => [
            'name' => 'lot_value', 'title' => 'Начальная цена', 'input' => ''
        ],
        'lot_step' => [
            'name' => 'lot_step', 'error_empty' => ''
        ],
        'lot_date' => [
            'name' => 'lot_date', 'error_empty' => 'Введите дату завершения торгов',
            'error_format' => 'Неправильный формат даты', 'error_date' => 'Дата меньше текущего значения'
        ]
    ]
];


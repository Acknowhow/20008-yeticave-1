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
            'name' => 'lot_step', 'title' => 'Шаг ставки', 'input' => ''
        ],
        'lot_date' => [
            'name' => 'lot_date',
            'title' => 'Дата завершения торгов', 'input' => ''
        ]
    ]
];


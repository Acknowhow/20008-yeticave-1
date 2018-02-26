<?php
function convertNum($num) {
    $num = ceil($num);

    if ($num > 1000) {
        $start = substr($num, 0, 2);

        $end = substr($num, 2, strlen($num) - 1);
        $num = $start . ' ' . $end . '&#8381';
    }

    return $num;
}

function include_template($templatePath, $templateData) {
    if(!file_exists($templatePath)) {

        return '';
    }
    if($templateData) {
        extract($templateData);
    }
    ob_start();
    require_once $templatePath;
    $tpl = ob_get_contents();
    ob_clean();

    return $tpl;
}
function getDateFormat($date, $format = 'Y-m-d'){
    $_date = DateTime::createFromFormat($format, $date);

    $_date && $_date->format($format) == $date ?
        $_date = '' : $_date = 'invalid';

    return $_date;
}

function validateDate($date) {
    $now = strtotime('now');

    $_date = getDateFormat($date);
    if (empty($_date)) {
        $end = strtotime($date);

        $min = round(($end - $now)/3600, 2);

        $is_day = $min > 24 ? '' :
            'Срок размещения лота должен быть больше одного дня';

        return $is_day;
    }
    return $_date;
}

function get_integer($val) {
    if (is_int($val + 0)) {
        return $val;
    }
    return 0;
}

function get_numeric($val) {
    if (is_numeric($val)) {
        return $val + 0;
    }
    return 0;
}

function validateLotRate($lotRate) {

    $is_numeric = get_numeric($lotRate);
    $is_positive = $lotRate > 0;

    if (empty($_lotRate)) {
        return 'Введите начальную цену';
    }
    if (!$is_numeric) {
        return 'Введите числовое значение';

    } elseif (!$is_positive) {
        return 'Введите число больше нуля';
    }
    return '';
}

function validateLotStep($lotStep) {

    $is_integer = get_integer($lotStep);
    $is_positive = $lotStep > 0;

    if (empty($_lotStep)) {
        return 'Введите шаг ставки';
    }
    if (!$is_integer) {
        return 'Введите целое число';

    } elseif (!$is_positive) {
        return 'Введите число больше нуля';
    }
    return '';
}

function validateUpload($array, $fileType, $fileSize) {
    $_result = array_filter(array_values($array), function($value) use ($fileType) {

        return $value == $fileType;
    }, ARRAY_FILTER_USE_KEY);

    if (empty($_result)) {
        return 'Пожалуйста, выберите файл правильного формата';
    }

    elseif ($fileSize > 200000) {
        return 'Максимальный размер файла: 200Кб';
    }
    return '';
}

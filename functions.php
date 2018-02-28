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
function getDateFormat($date, $format = 'd.m.Y'){
    $_date = DateTime::createFromFormat($format, $date);

    $_date && $_date->format($format) == $date ?
        $_date = '' : $_date = 'Пожалуйста, введите дату в формате ДД.ММ.ГГГГ';

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

function get_integer($val){
    $_val = $val + 0;
    if (is_int($_val)) {
        return $_val;
    }
    return 0;
}

function get_numeric($val){
    $_val = $val + 0;
    if (is_numeric($_val)) {
        return $_val;
    }
    return 0;
}

function validateLotValue($lotRate) {
    $_lotRate = $lotRate;

    $is_numeric = get_numeric($_lotRate);
    $is_positive = $_lotRate > 0;

    if (!$is_numeric) {
        return 'Начальная цена должна быть больше 0';

    } elseif (!$is_positive) {
        return 'Введите положительное числовое значение';
    }
    return '';
}

function validateLotStep($lotStep) {
    $_lotStep = $lotStep;

    $is_integer = get_integer($_lotStep);
    $is_positive = $_lotStep > 0;

    if (!$is_integer) {
        return 'Введите целое число больше 0';

    } elseif (!$is_positive) {
        return 'Введите целое положительное число';
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

function validateEmail($email)
{
    $_result = null;
    if (empty($_result = filter_var($email, FILTER_VALIDATE_EMAIL))) {
        $_result = 'format';

    } else {
        $_result = '';
    }
    return $_result;
}

function searchUserByEmail($email, $users, $register = false)
{
    $_result = null;
    foreach ($users as $user) {
        if ($user['email'] == $email) {
            $_result = $user;

            if ($register === true) {
                $_result = 'clone';
            }
            break;
        }
        $_result = 'match';

        if ($register === true) {
            $_result = '';
        }
    }
    return $_result;
}

function validateUser($email, $users, $password){
    $is_user = null;
    $user = searchUserByEmail($email, $users);

    if (is_string($user) || (is_array($user) && $is_user = password_verify($password, $user['password']))) {
        $is_user = $user;

    } elseif (is_array($user) && empty($is_user = password_verify($password, $user['password']))) {
        $is_user = 'invalid';
    }
    return $is_user;
}

function validatePassword($password){
    $_result = [];

    if(strlen($password) < 11) {
        return 'length_short';

    }
    elseif(strlen($password) >= 11 && strlen($password) <= 72) {
        $_result[] = password_hash($password, PASSWORD_DEFAULT);
        return $_result;

    }

    return 'length_long';
}

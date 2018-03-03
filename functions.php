<?php
require 'mysql_helper.php';
function convertNum($num)
{
    $num = ceil($num);

    if ($num > 1000) {
        $start = substr($num, 0, 2);

        $end = substr($num, 2, strlen($num) - 1);
        $num = $start . ' ' . $end . '&#8381';
    }

    return $num;
}

function include_template($templatePath, $templateData)
{
    if (!file_exists($templatePath)) {

        return '';
    }
    if ($templateData) {
        extract($templateData);
    }
    ob_start();
    require_once $templatePath;
    $tpl = ob_get_contents();
    ob_clean();

    return $tpl;
}

function getDateFormat($date, $format = 'd.m.Y')
{
    $_date = DateTime::createFromFormat($format, $date);

    $_date && $_date->format($format) == $date ?
        $_date = '' : $_date = '
        Пожалуйста, введите дату в формате ДД.ММ.ГГГГ';

    return $_date;
}

function validateDate($date)
{
    $now = strtotime('now');

    $_date = getDateFormat($date);
    if (empty($_date)) {
        $end = strtotime($date);

        $min = round(($end - $now) / 3600, 2);

        $is_day = $min > 24 ? '' :
            'Срок размещения лота должен быть больше одного дня';

        return $is_day;
    }
    return $_date;
}

function get_integer($val)
{
    $_val = $val + 0;
    if (is_int($_val)) {
        return $_val;
    }
    return 0;
}

function get_numeric($val)
{
    $_val = $val + 0;
    if (is_numeric($_val)) {
        return $_val;
    }
    return 0;
}

function validateLotValue($lotRate)
{
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

function validateLotStep($lotStep)
{
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


function validateUpload($array, $fileType, $fileSize)
{
    $_result = in_array($fileType, $array);
    if (empty($_result)) {
        return 'Пожалуйста, выберите файл правильного формата';
    } elseif ($fileSize > 200000) {
        return 'Максимальный размер файла: 200Кб';
    }
    return '';
}

function validateFile($fileReceived, $allowedTypes)
{
    $upload_params = [];
    $file_name = $fileReceived['name'];
    $file_name_tmp = $fileReceived['tmp_name'];

    $file_type = $fileReceived['type'];
    $file_size = $fileReceived['size'];

    $file_path = __DIR__ . '/img/';
    $file_url = 'img/' . $file_name;

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    finfo_close($finfo);

    $is_valid = validateUpload($allowedTypes,
        $file_type, $file_size);
    if (!empty($is_valid)) {
        return $is_valid;
    };

    $upload_params['file_path'] = $file_path;
    $upload_params['file_name'] = $file_name;
    $upload_params['file_name_tmp'] = $file_name_tmp;
    $upload_params['file_url'] = $file_url;

    return $upload_params;

}

function validateEmail($email)
{
    $_result = null;
    if (empty($_result = filter_var($email,
        FILTER_VALIDATE_EMAIL))) {
        $_result = 'Пожалуйста, введите правильный формат email';

    } else {
        $_result = '';
    }
    return $_result;
}

function validateUser($email, $users, $password)
{
    $is_user = null;
    $user = searchUserByEmail($email, $users);

    if (is_string($user) || !empty($is_user = password_verify(
            $password, $user['user_password']))) {
        $is_user = $user;

    } elseif (is_array($user) && empty($is_user = password_verify(
        $password, $user['user_password']))) {
        $is_user = 'Пароль неверный';
    }
    return $is_user;
}

function searchUserByEmail($email, $users, $register = false)
{
    $_result = null;
    foreach ($users as $user) {
        if ($user['user_email'] == $email) {
            $_result = $user;

            if ($register === true) {
                $_result = '
                Указанный вами email уже зарегистрирован';
            }
            break;
        }
        $_result = 'Вы указали неверный пароль или email';

        if ($register === true) {
            $_result = '';
        }
    }
    return $_result;
}



function validatePassword($password)
{
    $_result = [];

    if(strlen($password) < 11) {
        return '
        Пожалуйста, укажите не меньше 11 символов в вашем пароле';

    }
    elseif(strlen($password) >= 11 && strlen($password) <= 72) {
        $_result[] = password_hash($password, PASSWORD_DEFAULT);
        return $_result;

    }

    return 'Длина пароля должна быть не больше 72 символов';
}

// Select data
function select_column($link, $sql, $data, $columnName){
    $arr = [];
    $stmt = db_get_prepare_stmt($link, $sql, $data);

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        return false;
    }
    while($row = mysqli_fetch_array($result)){
        $arr[] = $row[$columnName];
    };
    return $arr;
}
// Select data
function select_data_assoc($link, $sql, $data){
    $arr = [];
    $stmt = db_get_prepare_stmt($link, $sql, $data);

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        return false;

    }
    while($row = mysqli_fetch_assoc($result)){
        $arr[] = $row;
    };
    return $arr;
}

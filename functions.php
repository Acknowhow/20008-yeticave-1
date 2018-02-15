<?php
function convertNum($num){
    $num = ceil($num);

    if ($num > 1000) {
        $start = substr($num, 0, 2);

        $end = substr($num, 2, strlen($num) - 1);
        $num = $start . ' ' . $end . '&#8381';
    }

    return $num;
}

function include_template($templatePath, $templateData){
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


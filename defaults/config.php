<?php
$is_auth = (bool)rand(0, 1);

$user_name = 'Константин';
$user_avatar = 'img/user.jpg';

date_default_timezone_set('Europe/Moscow');

$today = new DateTime('now');
$tomorrow = new DateTime('tomorrow midnight');

$difference = $today->diff($tomorrow);
$lot_time_remaining = $difference->format('%h:%i');

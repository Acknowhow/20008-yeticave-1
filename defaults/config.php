<?php
date_default_timezone_set('Europe/Moscow');
$is_auth = (bool)rand(0, 1);

$user_name = 'Константин';
$user_avatar = 'img/user.jpg';

$date_now = new DateTime('now');
$date_tomorrow = new DateTime('tomorrow midnight');

$date_difference = $date_now->diff($date_tomorrow);
$time_left = $date_difference->format('%h:%i');

<?php
date_default_timezone_set('Europe/Moscow');

$is_auth = false;
$user = isset($_SESSION['user']) ?
    $_SESSION['user'] : [];

if (!empty($user)) {
   $is_auth = true;
}
$date_now = new DateTime('now');
$date_tomorrow = new DateTime('tomorrow midnight');

$date_difference = $date_now->diff($date_tomorrow);
$time_left = $date_difference->format('%h:%i');

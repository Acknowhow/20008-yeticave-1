<?php
date_default_timezone_set('Europe/Moscow');
$bet_display_count = 4;
$is_auth = false;
$user = isset($_SESSION['user']) ?
    $_SESSION['user'] : [];

if (!empty($user)) {
   $is_auth = true;
}
$dtz = new DateTimeZone(date_default_timezone_get());
$date_current = new DateTime('now', $dtz);

<?php
date_default_timezone_set('Europe/Moscow');
$search = '';

$bet_display_count = 4;
$is_auth = false;
$user = isset($_SESSION['user']) ?
    $_SESSION['user'] : [];

if (!empty($user)) {
   $is_auth = true;
}
$dtz = new DateTimeZone(date_default_timezone_get());
$date_current = new DateTime('now', $dtz);

$curr_page = isset($_GET['page']) ? $_GET['page'] : 1;

$count = null;
$offset = null;

$page_items = 9;
$pages_count = null;

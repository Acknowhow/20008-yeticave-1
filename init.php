<?php
$link = mysqli_connect('localhost', 'root', 'vadi4ka365', 'yeti');
mysqli_set_charset($link, 'utf8');

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

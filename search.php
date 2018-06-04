<?php
$index = false;


//$nav = include_template('templates/nav.php',
//    [
//        'categories' => $categories
//    ]
//);
$new = htmlspecialchars("<a href='test'>Test</a>", ENT_QUOTES);
echo '&lsdt;a href=&#039;test&#039;&gt;Test&lt;/a&gt';


$search = htmlspecialchars($_GET['search'], ENT_QUOTES) ?? '';



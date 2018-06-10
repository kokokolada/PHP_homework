<?php //kasutame p2ringute tegemiseks

//    include "config.php";
//$host = "tigu.hk.tlu.ee";
$host= "localhost";
$db_name = "anneliserandmaa";
$db_user = "anneliserandmaa";
$db_pass = "5cPQkKbO";

$link = mysqli_connect($host, $db_user, $db_pass, $db_name) or die("ei saanud ühendust => " . mysqli_error($link));


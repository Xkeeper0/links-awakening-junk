<?php

// Connecting to database x.x
$db_user = "root";
$db_pass = "";
$db_select = "misc";

$connection = mysql_connect('localhost', $db_user, $db_pass) OR die("MySQL failure");
$db = mysql_select_db($db_select, $connection);

?>
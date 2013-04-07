<?php
require '../config/mysql.php';
$db = new PDO('mysql:host='.$dbhost.';dbname='.$dbname.';charset='.$dbcharset, $dbusername, $dbpassword);
?>
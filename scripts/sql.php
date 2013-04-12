<?php
require 'C:\xampp\htdocs\test\config\mysql.php';
$db = new PDO('mysql:host='.$dbhost.';dbname='.$dbname.';charset='.$dbcharset, $dbusername, $dbpassword);
?>
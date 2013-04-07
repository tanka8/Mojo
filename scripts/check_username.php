<?php
require 'sql.php';
$inputUsername = $_GET['inputUsername'];

$query = 'SELECT *  FROM `client_details` WHERE `username` = \''.$inputUsername.'\'';
$stmt = $db->query($query);
$row_count = $stmt->rowCount();

if ($row_count == '0') {
	echo "true";
} else {
	echo "false";
}
?>
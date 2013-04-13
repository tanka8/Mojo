<?php
require 'sql.php';
$inputServerIP = $_GET['inputServerIP'];

$query = 'SELECT *  FROM `whm_servers` WHERE `server_ip` = \''.$inputServerIP.'\'';
$stmt = $db->query($query);
$row_count = $stmt->rowCount();

if ($row_count == '0') {
	echo "true";
} else {
	echo "false";
}
?>
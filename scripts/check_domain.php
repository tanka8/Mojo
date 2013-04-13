<?php
require 'sql.php';
$inputDomain = $_GET['inputDomain'];

$query = 'SELECT *  FROM `shared_hosting` WHERE `domain` = \''.$inputDomain.'\'';
$stmt = $db->query($query);
$row_count = $stmt->rowCount();

if ($row_count == '0') {
	echo "true";
} else {
	echo "false";
}
?>
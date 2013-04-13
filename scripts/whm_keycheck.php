<?php
$server_id = $_GET['server_id'];
require 'sql.php';
$query = "SELECT * FROM `whm_servers` WHERE `server_id` = ".$server_id;
$stmt = $db->query($query);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$whmhash = $results[0]['remote_key'];
$whmip = $results[0]['server_ip'];
$whmusername = "root";

$query = "https://".$whmip.":2087/json-api/gethostname";

$curl = curl_init();
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,0);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
$header[0] = "Authorization: WHM $whmusername:" . preg_replace("'(\r|\n)'","",$whmhash);
curl_setopt($curl,CURLOPT_HTTPHEADER,$header);
curl_setopt($curl, CURLOPT_URL, $query);
$result = curl_exec($curl);
if ($result == false) {
error_log("curl_exec threw error \"" . curl_error($curl) . "\" for $query");
}
curl_close($curl);

if (strpos($result,'hostname') !== false) {
    header('Location: '.'../servers.php?form=key_ok');
	die;
}
else {
	header('Location: '.'../servers.php?form=key_fail');
	die;
}
?>
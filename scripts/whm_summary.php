<?php
$whmusername = "root";
$whmhash = $whm_server[0]['remote_key'];
$query = "https://".$shared_hosting[0]['mail_server'].":2087/json-api/accountsummary?user=".$client_product[0]['product_user'];
$curl = curl_init();
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,0);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,0);
curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
$header[0] = "Authorization: WHM $whmusername:" . $whmhash;
curl_setopt($curl,CURLOPT_HTTPHEADER,$header);
curl_setopt($curl, CURLOPT_URL, $query);
$whm_summary = curl_exec($curl);
if ($whm_summary == false) {
error_log("curl_exec threw error \"" . curl_error($curl) . "\" for $query");
}
curl_close($curl);
$obj = json_decode($whm_summary);
$array = $obj->{'acct'};

if ((str_replace('M', '', $array[0]->suspended)) == 1) {$whm_suspended = true;} else {$whm_suspended = false;}
$whm_disk_used = str_replace('', 'M', str_replace('M', '', $array[0]->diskused));
$whm_disk_limit = str_replace('', 'M', str_replace('M', '', $array[0]->disklimit));
?>
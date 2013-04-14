<?php
$url = "http://whois.registry.net.za/whois/whois.sh?Domain=".$shared_hosting[0]['domain'];

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HEADER, 0);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_TIMEOUT, 5);
$output = curl_exec($curl);
curl_close($curl);

preg_match("'Renewal Date:(.*?)Domain Status:'si", $output, $result);
$domain_renewal = trim($result[1]);

preg_match("'Registrar:(.*?)\[ ID ='si", $output, $result);
$domain_registrar = trim($result[1]);

preg_match("'Domain Status:(.*?)Pending Timer Events:'si", $output, $result);
$domain_status = trim($result[1]);

preg_match("'Name Servers:(.*?)WHOIS lookup'si", $output, $result);
$domain_nameservers = trim($result[1]);
$domain_nameservers = preg_split('/[\r\n]+/', $domain_nameservers);
$domain_nameservers = array_map('trim',$domain_nameservers);
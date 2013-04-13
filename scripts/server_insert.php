<?php 
require 'sql.php';
$inputServerName = $_POST['inputServerName'];
$inputServerHostname = $_POST['inputServerHostname'];
$inputServerIP = $_POST['inputServerIP'];
$inputRemoteKey = $_POST['inputRemoteKey'];
$inputRootPassword = $_POST['inputRootPassword'];

if ($inputServerName == "" or $inputServerHostname == "" or $inputServerIP == "" or $inputRemoteKey == "" or $inputRootPassword == "") {
?>
<div class="alert">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Error:</strong> Please refreash the page make sure all details are filled in.
</div>
<?php
	die();
}
//$time = time();

$query = 'INSERT INTO `whm_servers` (`server_id`, `server_name`, `server_hostname`, `server_ip`, `remote_key`, `root_password`) VALUES (NULL, \''.$inputServerName.'\', \''.$inputServerHostname.'\', \''.$inputServerIP.'\', \''.$inputRemoteKey.'\', \''.$inputRootPassword.'\')';
$result = $db->exec($query);
?>
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>Server added:</strong> The server has with the submitted details.
</div>
<p>Click <a href="new_server.php">here</a> to add a new server.</p>
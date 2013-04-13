<?php 
require 'sql.php';
$inputServerID = $_POST['inputServerID'];
$inputServerName = $_POST['inputServerName'];
$inputServerHostname = $_POST['inputServerHostname'];
$inputRemoteKey = $_POST['inputRemoteKey'];
$inputRootPassword = $_POST['inputRootPassword'];
if ($inputServerID == "" or $inputServerName == "" or $inputServerHostname == "" or $inputRemoteKey == "" or $inputRootPassword == "") {
?>
<div class="alert">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Error:</strong> Please refreash the page make sure all details are filled in.
</div>
<?php
	die();
}
$query = 'UPDATE `whm_servers` SET `server_name` = \''.$inputServerName.'\', `server_hostname` = \''.$inputServerHostname.'\', `remote_key` = \''.$inputRemoteKey.'\', `root_password` = \''.$inputRootPassword.'\' WHERE `server_id` = '.$inputServerID.';';
$result = $db->exec($query);
?>
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>Server Update:</strong> The Server details have been updated.
</div>
<p>Click <a href="serverdetails.php?id=<?php echo $inputServerID;?>">here</a> to go back to the server details.</p>
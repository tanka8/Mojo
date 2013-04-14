<?php
$page_title = "Server Details";
$query = true;
require 'header.php';
$server_id = $_GET['id'];
if($server_id == '') {
	header('Location: servers.php');
}
$query = "SELECT * FROM `whm_servers` WHERE `server_id` = '".$server_id."'";
$stmt = $db->query($query);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$row_count = $stmt->rowCount();
if ($row_count == '0') {
	header('Location: servers.php');
	}
?>
<div class="page-header">
	<h1>Server Details</h1>
</div>
<?php
if(isset($_GET['msg'])) {
if ($_GET['msg'] == "Update") {
	?>
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>Success:</strong> Server details has been updated.
</div>
<?php
}
}
?>
<form class="form-horizontal" action="#" id="server_update">
	<input value="<?php echo $server_id?>" type="hidden" name="inputServerID" id="inputServerID">
	<div class="control-group">
		<label class="control-label" for="inputServerName">Server Name</label>
		<div class="controls">
			<input value="<?php echo $results[0]['server_name'];?>" type="text" class="input tp" name="inputServerName" id="inputServerName" placeholder="Server Name">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputServerHostname">Server Hostname</label>
		<div class="controls">
			<input value="<?php echo $results[0]['server_hostname'];?>" type="text" class="input tp" name="inputServerHostname" id="inputServerHostname" placeholder="Server Hostame">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputServerIP">Server IP</label>
		<div class="controls">
			<input value="<?php echo $results[0]['server_ip'];?>" type="text" class="input tp" name="inputServerIP" id="inputServerIP" placeholder="Server IP" disabled>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputRemoteKey">Remote Key</label>
		<div class="controls">
			<input value="<?php echo $results[0]['remote_key'];?>" type="text" class="input tp" name="inputRemoteKey" id="inputRemoteKey" placeholder="Remote Key">    
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputRootPassword">Root Password</label>
		<div class="controls">
			<input value="<?php echo $results[0]['root_password'];?>" type="text" class="input tp" name="inputRootPassword" id="inputRootPassword" placeholder="Root Password">
		</div>
	</div>
	<div class="form-actions">
		<div class="controls submit">
			<button type="submit" class="btn btn-primary loadingbtn" id="submitbutton">Update Server</button>
		</div>
	</div>
</form>
<?php
$script = "
<script type='text/javascript'>
$('#server_update').validate({  
        rules: {
			inputServerName: {required: true, maxlength: 255},
			inputServerHostname: {required: true, maxlength: 255},
			inputRemoteKey: {required: true},
			inputRootPassword: {required: true, maxlength: 255}
        },
		highlight: function(label) {
			$(label).closest('.control-group').addClass('error');
		},
		success: function(label) {
			label
			.addClass('valid')
			.closest('.control-group').addClass('success');
		},
		submitHandler: function(form) {
		$('.loadingbtn').button('loading');
		serverupdatefunct();
		}
		

});
function serverupdatefunct() {
$.ajax({
	type: \"POST\",
	url: \"scripts/server_update.php\",
	data: {inputServerID: document.getElementById(\"inputServerID\").value, inputServerName: document.getElementById(\"inputServerName\").value, inputServerHostname: document.getElementById(\"inputServerHostname\").value, inputRemoteKey: document.getElementById(\"inputRemoteKey\").value, inputRootPassword: document.getElementById(\"inputRootPassword\").value},
	success: function(response){
		$('#server_update').html(response)
        }
 });
 }
</script>";
require 'footer.php';
?>
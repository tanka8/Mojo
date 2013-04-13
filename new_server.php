<?php
$page_title = "New Server";
require 'header.php';
?>
<div class="page-header">
	<h1>Add a server</h1>
</div>
<form class="form-horizontal" action="" id="server_insert">
	<div class="control-group">
		<label class="control-label" for="inputServerName">Server Name</label>
		<div class="controls">
			<input type="text" class="input tp" name="inputServerName" id="inputServerName" placeholder="Server Name">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputServerHostname">Server Hostname</label>
		<div class="controls">
			<input type="text" class="input tp" name="inputServerHostname" id="inputServerHostname" placeholder="Server Hostname">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputServerIP">Server IP Address</label>
		<div class="controls">
			<input type="text" class="input tp" name="inputServerIP" id="inputServerIP" placeholder="Server IP Address">    
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputRemoteKey">Remote Key</label>
		<div class="controls">
			<input type="text" class="input tp" name="inputRemoteKey" id="inputRemoteKey" placeholder="Remote Key">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputRootPassword">Root Password</label>
		<div class="controls">
			<input type="text" class="input tp" name="inputRootPassword" id="inputRootPassword" placeholder="Root Password">
		</div>
	</div>
	<div class="form-actions">
		<div class="controls submit">
			<button type="submit" class="btn btn-primary loadingbtn" id="submitbutton">Create Server</button>
		</div>
	</div>
</form>
<?php
$script = "
<script type='text/javascript'>
$('#server_insert').validate({
        rules: {
			inputServerName: {required: true, maxlength: 255},
			inputServerHostname: {required: true, maxlength: 255},
            inputServerIP: {
                required: true,
                maxlength: 15,
                remote: 'scripts/check_server.php'
			},
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
        messages: {
            inputServerIP:{
                remote: 'Username taken. Please try another.'
            }
        },
		submitHandler: function(form) {
		$('.loadingbtn').button('loading');
		servercreatefunct();
		}
		

});
function servercreatefunct() {
$.ajax({
	type: \"POST\",
	url: \"scripts/server_insert.php\",
	data: {inputServerName: document.getElementById(\"inputServerName\").value, inputServerHostname: document.getElementById(\"inputServerHostname\").value, inputServerIP: document.getElementById(\"inputServerIP\").value, inputRemoteKey: document.getElementById(\"inputRemoteKey\").value, inputRootPassword: document.getElementById(\"inputRootPassword\").value},
	success: function(response){
		$('#server_insert').html(response)
        }
 });
 }
</script>";
require 'footer.php';
?>
<?php
$page_title = "Home";
require 'header.php';
?>
<div class="page-header">
	<h1>Create a new client</h1>
</div>
<form class="form-horizontal" action="" id="client_insert">
	<div class="control-group">
		<label class="control-label" for="inputFirstName">First Name</label>
		<div class="controls">
			<input type="text" class="input tp" name="inputFirstName" id="inputFirstName" placeholder="First Name">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputLastName">Last Name</label>
		<div class="controls">
			<input type="text" class="input tp" name="inputLastName" id="inputLastName" placeholder="Last Name">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputUsername">Username</label>
		<div class="controls">
			<input type="text" class="input tp" name="inputUsername" id="inputUsername" placeholder="Username">    
		</div>
	</div>

	<div class="form-actions">
		<div class="controls submit">
			<button type="submit" class="btn btn-primary loadingbtn" id="submitbutton">Create User</button>
		</div>
	</div>
<?php
$script = "
<script type='text/javascript'>
$('#client_insert').validate({  
        rules: {
			inputFirstName: {required: true, maxlength: 255},
			inputLastName: {required: true, maxlength: 255},
            inputUsername: {
                required: true,
                maxlength: 255,
                remote: 'scripts/check_username.php'
			}
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
            inputUsername:{
                remote: 'Username taken. Please try another.'
            }
        },
		submitHandler: function(form) {
		$('.loadingbtn').button('loading');
		usercreatefunct();
		}
		

});
function usercreatefunct() {
$.ajax({
	type: \"POST\",
	url: \"scripts/client_insert.php\",
	data: {inputFirstName: document.getElementById(\"inputFirstName\").value, inputLastName: document.getElementById(\"inputLastName\").value, inputUsername: document.getElementById(\"inputUsername\").value},
	success: function(response){
		$('#client_insert').html(response)
        }
 });
 }
</script>";
require 'footer.php';
?>
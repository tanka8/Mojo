<?php
$page_title = "Client Details";
$query = true;
require 'header.php';
$client_id = $_GET['id'];
if($client_id == '') {
	header('Location: clients.php');
}
$query = "SELECT * FROM `client_details` WHERE `client_id` = '".$client_id."'";
$stmt = $db->query($query);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$row_count = $stmt->rowCount();
if ($row_count == '0') {
	header('Location: clients.php');
	}
?>
<div class="page-header">
	<h1>Client Details</h1>
</div>
<?php
if(isset($_GET['msg'])) {
if ($_GET['msg'] == "Update") {
	?>
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>Success:</strong> User details has been updated.
</div>
<?php
}
}
?>
<div class="tabbable">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#details" data-toggle="tab">Details</a></li>
    <li><a href="#products" data-toggle="tab">Products</a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane active" id="details">
    <form class="form-horizontal" action="" id="client_update">
	<input value="<?php echo $client_id?>" type="hidden" name="client_id" id="client_id">
	<div class="control-group">
		<label class="control-label" for="inputFirstName">First Name</label>
		<div class="controls">
			<input value="<?php echo $results[0]['first_name'];?>" type="text" class="input tp" name="inputFirstName" id="inputFirstName" placeholder="First Name">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputLastName">Last Name</label>
		<div class="controls">
			<input value="<?php echo $results[0]['last_name'];?>" type="text" class="input tp" name="inputLastName" id="inputLastName" placeholder="Last Name">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputUsername">Username</label>
		<div class="controls">
			<input value="<?php echo $results[0]['username'];?>" type="text" class="input tp" name="inputUsername" id="inputUsername" placeholder="Username" disabled>    
		</div>
	</div>
	<div class="form-actions">
		<div class="controls submit">
			<button type="submit" class="btn btn-primary loadingbtn" id="submitbutton">Update User</button>
		</div>
	</div>
	</form>
    </div>
      <div class="tab-pane" id="products">
      <p>Products</p>
    </div>
  </div>
</div>
<?php
$script = "
<script type='text/javascript'>
$('#client_update').validate({  
        rules: {
			inputFirstName: {required: true, maxlength: 255},
			inputLastName: {required: true, maxlength: 255},
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
		userupdatefunct();
		}
		

});
function userupdatefunct() {
$.ajax({
	type: \"POST\",
	url: \"scripts/client_update.php\",
	data: {inputClient_ID: document.getElementById(\"client_id\").value, inputFirstName: document.getElementById(\"inputFirstName\").value, inputLastName: document.getElementById(\"inputLastName\").value, inputUsername: document.getElementById(\"inputUsername\").value},
	success: function(response){
		$('#client_update').html(response)
        }
 });
 }
</script>";
require 'footer.php';
?>
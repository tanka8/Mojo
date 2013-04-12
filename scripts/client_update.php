<?php 
require 'sql.php';
$inputClient_ID = $_POST['inputClient_ID'];
$inputFirstName = $_POST['inputFirstName'];
$inputLastName = $_POST['inputLastName'];
$inputUsername = $_POST['inputUsername'];
if ($inputFirstName == "" or $inputLastName == "" or $inputUsername == "") {
?>
<div class="alert">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Error:</strong> Please refreash the page make sure all details are filled in.
</div>
<?php
	die();
}
$time = time();
$query = 'UPDATE `client_details` SET `first_name` = \''.$inputFirstName.'\', `last_name` = \''.$inputLastName.'\', `updated_time` = \''.$time.'\' WHERE `client_id` = '.$inputClient_ID.';';
$result = $db->exec($query);
?>
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>User Update:</strong> The user details have been updated.
</div>
<p>Click <a href="clientdetails.php?id=<?php echo $inputClient_ID;?>">here</a> to go back to the client details.</p>
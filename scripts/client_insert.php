<?php 
require 'sql.php';
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

$query = 'INSERT INTO `client_details` (`client_id`, `first_name`, `last_name`, `username`, `created_time`, `updated_time`) VALUES (NULL, \''.$inputFirstName.'\', \''.$inputLastName.'\', \''.$inputUsername.'\', \''.$time.'\', \''.$time.'\')';
$result = $db->exec($query);
?>
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>User created:</strong> The user has been created with the submitted details.
</div>
<p>Click <a href="new_client.php">here</a> to create a new user or click <a href="clients.php">here</a> to view a user listing</p>
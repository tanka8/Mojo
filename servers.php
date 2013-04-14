<?php
$page_title = "Server Listing";
$query = true;
require 'header.php';
$query = "SELECT * FROM `whm_servers`";
$stmt = $db->query($query);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (isset($_GET['form'])) { 
$form = $_GET['form'];
if ($form == 'key_ok') {
?>
<div class="alert alert-success">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>Key Worked:</strong> The key appears to be able to retrive data.
</div>
<?php
}
if ($form == 'key_fail') {
?>
<div class="alert alert-error">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>Key Failed:</strong> The system was not able to retrieve data from the server with the provided key.
</div>
<?php
}
}
?>
<div class="page-header">
	<h1>Server listing</h1>
</div>
<a class="btn btn-primary" href="new_server.php">Add Server</a>
<hr>
<table class="table table-striped table-bordered table-hover">
<thead>
<tr><th>Server ID</th><th>Server Name</th><th>Hostname</th><th>IP Address</th><th>Remote Key</th><th>WHM Login</th><th>Edit</th></tr>
</thead>
<?php
foreach ($results as $value) {
$root = $value['root_password'];
?>
<tr>
<th><?php echo $value['server_id'];?></th>
<th><?php echo $value['server_name'];?></th>
<th><?php echo $value['server_hostname'];?></th>
<th><?php echo $value['server_ip'];?></th>
<th><a href="scripts/whm_keycheck.php?server_id=<?php echo $value['server_id'];?>"><i class="icon-question-sign"></i></a></th>
<th><a href="https://<?php echo $value['server_hostname'];?>:2087/login?user=root&amp;pass=<?php echo htmlentities($root);?>"><i class="icon-check"></i></a></th>
<th><a href="serverdetails.php?id=<?php echo $value['server_id']; ?>"><i class="icon-edit"></i></a></th>
<?php
}
?>
</table>
<?php
$script = "
<script type='text/javascript'>
</script>";
require 'footer.php';
?>
<?php
$page_title = "Client Listing";
$query = true;
require 'header.php';
$query = "SELECT * FROM `client_details`";
$stmt = $db->query($query);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="page-header">
	<h1>Client listing</h1>
</div>
<table class="table table-striped table-bordered table-hover">
<thead>
<tr><th>Client ID</th><th>First Name</th><th>Last Name</th><th>Username</th><th>Created</th><th>Last edited</th></tr>
</thead>
<?php
foreach ($results as $value) {
?>
<tr>
<th><?php echo $value['client_id'];?></th>
<th><?php echo $value['first_name'];?></th>
<th><?php echo $value['last_name'];?></th>
<th><?php echo $value['username'];?></th>
<th><?php echo (date('Y-m-d - H:i:s', $value['updated_time']));?></th>
<th><?php if($value['updated_time'] == $value['created_time']) {echo "Never edited";} else {echo (date('Y-m-d - H:i:s', $value['created_time']));}?></th>
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
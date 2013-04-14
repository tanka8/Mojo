<?php
$page_title = "Home";
$query = true;
require 'header.php';
?>
<h1>My Mojo</h1>
<div class="span4">
	<h2>Newest clients</h2>
	<table class="table table-striped table-bordered table-hover">
	<thead>
	<tr><th>Client ID</th><th>Username</th><th>View</th></tr>	
	</thead>
	<?php 	
	$query = "SELECT * FROM  `client_details` ORDER BY  `client_details`.`created_time` ASC LIMIT 0 , 10";
	$stmt = $db->query($query);
	$newest_clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

	foreach($newest_clients as $value){?>
	<tr><th><?php echo $value['client_id']; ?></th><th><?php echo $value['username']; ?></th><th><a href="clientdetails.php?id=<?php echo $value['client_id']; ?>"><i class="icon-edit"></i></a></th></tr>
	<?php
	}
	?>
	</table>

</div>
<?php
require 'footer.php';
?>